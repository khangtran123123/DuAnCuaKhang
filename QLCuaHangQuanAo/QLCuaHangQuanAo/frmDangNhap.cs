using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.Data.SqlClient;

namespace QLCuaHangQuanAo
{
    public partial class frmDangNhap : Form
    {
        public frmDangNhap()
        {
            InitializeComponent();
      
        }

        private void btnDangNhap_Click(object sender, EventArgs e)
        {
            SqlConnection conn=new SqlConnection("Data Source=(LocalDB)\\MSSQLLocalDB;AttachDbFilename=\"D:\\LapTrinh net\\DoAn2\\QLCuaHangQuanAo\\QLCuaHangQuanAo\\QLCuaHangQuanAo.mdf\";Integrated Security=True");
            try
            {
                conn.Open();
                string tk=txtTenTaiKhoan.Text;
                string mk=txtMatKhau.Text;
                string sql = "select * from tblQL where TenQL ='"+tk+"' and MatKhauQL='"+mk+"'";
                SqlCommand cmd = new SqlCommand(sql, conn);
                SqlDataReader dta= cmd.ExecuteReader();
                if (dta.Read() == true)
                {
                    frmMain frmmain = new frmMain();
                    frmmain.ShowDialog();
                    this.Close();
                }
                else MessageBox.Show("Bạn đã nhập sai tên tài khoản hoặc sai mật khẩu!");                   
            }
            catch 
            {
                MessageBox.Show("Lỗi Kết Nối!");
            }
        }

        private void cbHienThiMK_CheckedChanged(object sender, EventArgs e)
        {
            txtMatKhau.PasswordChar = cbHienThiMK.Checked ? '\0' : '*';
        }

        private void btnQuenMK_Click(object sender, EventArgs e)
        {
            frmQuenMK frmQuenMK = new frmQuenMK();
            frmQuenMK.ShowDialog();
        }
    }
}
