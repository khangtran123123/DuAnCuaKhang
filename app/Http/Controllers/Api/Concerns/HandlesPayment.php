<?php

namespace App\Http\Controllers\Api\Concerns;

use App\Models\Invoice;
use App\Models\RoomBooking;
use App\Models\TourBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Các helper chuyển khoản / thanh toán dùng chung cho BookingController,
 * ComboBookingController và PaymentController.
 */
trait HandlesPayment
{
    // ── Xác nhận thanh toán hóa đơn (cập nhật DB) ─────────────────────────

    protected function confirmInvoicePayment(int $maHD): void
    {
        DB::transaction(function () use ($maHD) {
            Invoice::where('MaHD', $maHD)->update(['TrangThai' => 1, 'ThanhToan' => 1]);
            RoomBooking::where('MaHD', $maHD)->where('TrangThai', 1)->update(['ThanhToan' => 1]);
            TourBooking::where('MaHD', $maHD)->where('TrangThai', 1)->update(['ThanhToan' => 1]);
        });
    }

    // ── Nội dung chuyển khoản & QR ────────────────────────────────────────

    protected function buildTransferDescription(int $invoiceId): string
    {
        return 'THANH TOAN HD' . $invoiceId;
    }

    protected function buildVietQrUrl(float $amount, string $description): string
    {
        $bankId      = env('HOTEL_BANK_ID', 'MB');
        $accountNo   = env('HOTEL_ACCOUNT_NO', '');
        $accountName = env('HOTEL_ACCOUNT_NAME', 'KHACH SAN');

        if (empty($accountNo)) {
            return 'https://quickchart.io/qr?size=280&text=' . urlencode($description);
        }

        return sprintf(
            'https://img.vietqr.io/image/%s-%s-compact2.png?amount=%s&addInfo=%s&accountName=%s',
            urlencode($bankId),
            urlencode($accountNo),
            number_format($amount, 0, '.', ''),
            urlencode($description),
            urlencode($accountName),
        );
    }

    protected function getBankInfo(): array
    {
        return [
            'bank_id'      => env('HOTEL_BANK_ID', 'MB'),
            'account_no'   => env('HOTEL_ACCOUNT_NO', ''),
            'account_name' => env('HOTEL_ACCOUNT_NAME', 'KHACH SAN'),
        ];
    }

    // ── Webhook helpers ────────────────────────────────────────────────────

    protected function extractInvoiceIdFromTransferContent(string $content): ?int
    {
        if (preg_match('/(?:HD|HĐ|MA\s*HD|MAHD|HOA\s*DON|HOA\s*D[OÔ]N)\s*[:#-]?\s*([0-9]{1,10})/iu', $content, $matches) === 1) {
            return (int) ($matches[1] ?? 0) ?: null;
        }

        // Fallback: nội dung có từ khóa thanh toán nhưng không có prefix HD
        $hasTransferKeyword = preg_match('/THANH\s*TOAN|CHUYEN\s*KHOAN|TRANSFER|PAYMENT/iu', $content) === 1;
        if ($hasTransferKeyword && preg_match_all('/([0-9]{2,10})/u', $content, $allMatches) > 0) {
            $numbers = $allMatches[1] ?? [];
            if (count($numbers) === 1) {
                return (int) $numbers[0] ?: null;
            }
        }

        return null;
    }

    protected function parseTransferAmount(mixed $rawAmount): ?float
    {
        if ($rawAmount === null) {
            return null;
        }

        if (is_int($rawAmount) || is_float($rawAmount)) {
            return (float) $rawAmount;
        }

        $amount = trim((string) $rawAmount);
        if ($amount === '') {
            return null;
        }

        $amount = preg_replace('/[^0-9,.-]/u', '', $amount) ?? '';
        if ($amount === '') {
            return null;
        }

        $commaCount = substr_count($amount, ',');
        $dotCount   = substr_count($amount, '.');

        if ($commaCount > 0 && $dotCount > 0) {
            $lastCommaPos = strrpos($amount, ',');
            $lastDotPos   = strrpos($amount, '.');

            if ($lastCommaPos !== false && $lastDotPos !== false && $lastCommaPos > $lastDotPos) {
                // Ví dụ: 1.234,56
                $amount = str_replace('.', '', $amount);
                $amount = str_replace(',', '.', $amount);
            } else {
                // Ví dụ: 1,234.56
                $amount = str_replace(',', '', $amount);
            }
        } elseif ($commaCount > 0) {
            $lastCommaPos   = strrpos($amount, ',');
            $decimalsLength = $lastCommaPos !== false ? strlen(substr($amount, $lastCommaPos + 1)) : 0;

            if ($commaCount === 1 && $decimalsLength > 0 && $decimalsLength <= 2) {
                $amount = str_replace(',', '.', $amount);
            } else {
                $amount = str_replace(',', '', $amount);
            }
        } elseif ($dotCount > 1) {
            // Ví dụ: 1.234.567
            $amount = str_replace('.', '', $amount);
        }

        if (!is_numeric($amount)) {
            return null;
        }

        $parsedAmount = (float) $amount;
        return is_finite($parsedAmount) ? $parsedAmount : null;
    }

    // ── Bảo mật ───────────────────────────────────────────────────────────

    protected function isManualConfirmAuthorized(Request $request): bool
    {
        $secret = trim((string) env('MANUAL_PAYMENT_CONFIRM_SECRET', ''));
        if ($secret === '') {
            return false;
        }

        $headerSecret = trim((string) $request->header('X-Manual-Confirm-Secret', ''));
        $bodySecret   = trim((string) $request->input('secret', ''));

        return hash_equals($secret, $headerSecret) || hash_equals($secret, $bodySecret);
    }
}
