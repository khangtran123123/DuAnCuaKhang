<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Xác thực quên mật khẩu</title>
</head>
<body>
    <p>Xin chào,</p>
    <p>Bạn đã yêu cầu đặt lại mật khẩu tài khoản. Vui lòng sử dụng mã bên dưới để xác thực:</p>

    <div style="padding: 10px; border: 1px dashed #000; display: inline-block; margin: 10px 0; font-size: 24px; font-weight: bold;">
        {{ $code }}
    </div>

    <p>Mã này có hiệu lực trong 10 phút. Nếu bạn không yêu cầu thao tác này, hãy bỏ qua email và kiểm tra lại bảo mật tài khoản.</p>

    <p>Chúc bạn một ngày tốt lành!</p>
    <p><strong>Đội ngũ hỗ trợ</strong></p>
</body>
</html>