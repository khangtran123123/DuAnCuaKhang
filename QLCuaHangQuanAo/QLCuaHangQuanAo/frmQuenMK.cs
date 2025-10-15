using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Data.SqlClient;
using System.Drawing;
using System.Linq;
using System.Net.Mail;
using System.Net;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.Net.Mail;
using System.Net;


namespace QLCuaHangQuanAo
{
    public partial class frmQuenMK : Form
    {
        public frmQuenMK()
        {
            InitializeComponent();
            lblAn.Visible = false;
            txtGmail.Focus();
        }

        private Random rd = new Random();

        private string connectionString = @"Data Source=(LocalDB)\MSSQLLocalDB;AttachDbFilename=""D:\LapTrinh net\backUpDoAn2\QLCuaHangQuanAo\QLCuaHangQuanAo\QLCuaHangQuanAo.mdf"";Integrated Security=True";

        public int RandomOTP()
        {
            int otp = rd.Next(100000, 999999);
            return otp;
        }
        
        
        private bool SendEmail(int otp, string email)
        {
            try
            {
                string to = txtGmail.Text;
                MailMessage mail = new MailMessage();
                mail.To.Add(to);
                mail.From = new MailAddress("tranvikhang227825@gmail.com");
                mail.Subject = "Đổi mật khẩu";
                mail.Body = $"Tin nhắn tự động: Mã xác nhận của bạn là {otp}";

                SmtpClient smtp = new SmtpClient("smtp.gmail.com");
                smtp.EnableSsl = true;
                smtp.Port = 587;
                smtp.DeliveryMethod = SmtpDeliveryMethod.Network;
                smtp.Credentials = new NetworkCredential("tranvikhang227825@gmail.com", "wxky zgfb rniq uocz");
                smtp.Send(mail);
                return true;
            }
            catch (Exception ex)
            {
                MessageBox.Show("Lỗi khi gửi mail!", ex.Message);
                return false;
            }
        }

        private void btnGuiMa_Click_1(object sender, EventArgs e)
        {
            string email = txtGmail.Text.Trim();
            int otp = RandomOTP();
            lblAn.Text = otp.ToString();
            if (string.IsNullOrEmpty(email))
            {
                MessageBox.Show("Vui lòng nhập email!");
                return;
            }

            if (SendEmail(otp, email))
            {
                MessageBox.Show("Đã gửi mã Xác nhận!");
            }
            else
            {
                MessageBox.Show("Lỗi khi gửi email");
            }
        }

        private void btnTaoMKM_Click(object sender, EventArgs e)
        {

         
            if (string.IsNullOrEmpty(txtMatKhauMoi.Text) || string.IsNullOrEmpty(txtNhapLaiMK.Text))
            {
                MessageBox.Show("Hãy nhập mật khẩu mới và xác nhận mật khẩu");
                return;
            }

            //Kiểm tra xác nhận mật khẩu mới
            if (txtNhapLaiMK.Text != txtMatKhauMoi.Text)
            {
                MessageBox.Show("Xác nhận mật khẩu mới sai");
                return ;
            }
            if (txtMaXacNhan.Text == lblAn.Text && txtNhapLaiMK.Text == txtMatKhauMoi.Text)
            {
                string sql = @"
                UPDATE tblQL
                SET MatKhauQL = @Newpass
                WHERE Email = '" + txtGmail.Text + "'";

                using (SqlConnection connection = new SqlConnection(connectionString))
                {
                    using (SqlCommand command = new SqlCommand(sql, connection))
                    {
                        command.Parameters.AddWithValue("@Newpass", txtMatKhauMoi.Text);

                        connection.Open();
                        int rowsAffected = command.ExecuteNonQuery();
                        try
                        {                            
                                MessageBox.Show("Đã đổi mật khẩu thành công.");
                                                       
                        }
                        catch (Exception ex)
                        {
                            MessageBox.Show($"Error: {ex.Message}");
                        }                       
                    }
                }
            }
        }

        private void btnThoat_Click(object sender, EventArgs e)
        {
            this.Close();
        }
    }
}
