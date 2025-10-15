using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Data.SqlClient;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using static System.Windows.Forms.VisualStyles.VisualStyleElement;

namespace QLCuaHangQuanAo
{
    public partial class frmHoaDon : Form
    {
        public frmHoaDon()
        {
            InitializeComponent();

        }
        Modify modify = new Modify();

        private void frmHoaDon_Load(object sender, EventArgs e)
        {
            dgvHoaDon.DataSource = modify.Table("select * from tblHoaDon");

            dgvHoaDon.Columns[0].HeaderText = "Mã Hóa Đơn";
            dgvHoaDon.Columns[0].Width = 200;
            dgvHoaDon.Columns[1].HeaderText = "Mã Quản Lý";
            dgvHoaDon.Columns[1].Width = 250;
            dgvHoaDon.Columns[2].HeaderText = "Mã Khách";
            dgvHoaDon.Columns[2].Width = 150;
            dgvHoaDon.Columns[3].HeaderText = "Tổng Tiền";
            dgvHoaDon.Columns[3].Width = 150;
            dgvHoaDon.Columns[4].HeaderText = "Tổng Tiền";
            dgvHoaDon.Columns[4].Width = 150;
            dgvHoaDon.Columns[5].HeaderText = "Ngày Bán";
            dgvHoaDon.Columns[5].Width = 150;
        }

        private void dgvHoaDon_CellClick(object sender, DataGridViewCellEventArgs e)
        {
            int i;
            i = dgvHoaDon.CurrentRow.Index;
            txtMaHD.Text = dgvHoaDon.Rows[i].Cells[0].Value.ToString();
            txtMaQL.Text = dgvHoaDon.Rows[i].Cells[1].Value.ToString();
            txtMaKhach.Text = dgvHoaDon.Rows[i].Cells[2].Value.ToString();
            txtGiamGia.Text= dgvHoaDon.Rows[i].Cells[3].Value.ToString();
            txtTongTien.Text = dgvHoaDon.Rows[i].Cells[4].Value.ToString();
            dtpNgayNhap.Text = dgvHoaDon.Rows[i].Cells[5].Value.ToString();

            //dgv Chi tiết hóa đơn
            
            dgvCTHD.DataSource = modify.Table("SELECT * FROM tblCHiTietHD where MaHD='"+txtMaHD.Text+"'");

            dgvCTHD.Columns[0].HeaderText = "Mã Hóa Đơn";
            dgvCTHD.Columns[0].Width = 100;
            dgvCTHD.Columns[1].HeaderText = "Mã Sản Phẩm";
            dgvCTHD.Columns[1].Width = 200;
            dgvCTHD.Columns[2].HeaderText = "Số Lượng";
            dgvCTHD.Columns[2].Width = 200;
            dgvCTHD.Columns[3].HeaderText = "Đơn Giá";
            dgvCTHD.Columns[3].Width = 250;
            dgvCTHD.Columns[4].HeaderText = "Thành Tiền";
            dgvCTHD.Columns[4].Width = 350;

            //dgvCTHD.DataSource = modify.Table("select * from tblChiTietHD where MaHD ='" + txtMaHD + "'");
        }

        private void btnThoat_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        private void btnXoaHD_Click(object sender, EventArgs e)
        {
            try
            {
                DialogResult result = MessageBox.Show("Bạn có chắc chắn muốn xóa không?", "Xác nhận", MessageBoxButtons.YesNo, MessageBoxIcon.Question);
                
                if (result == DialogResult.Yes)
                {
                    modify.Command("delete from tblChiTietHD where MaHD='" + txtMaHD.Text + "'");
                    modify.Command("delete from tblHoaDon where MaHD='" + txtMaHD.Text + "'");
                    dgvCTHD.DataSource = modify.Table("select * from tblChiTietHD");
                    dgvHoaDon.DataSource = modify.Table("select * from tblHoaDon");
                    MessageBox.Show("Dữ liệu đã bị xóa.", "Thông báo");
                }
                else
                {
                    MessageBox.Show("Hủy xóa dữ liệu.", "Thông báo");
                }

            }
            catch
            {
                MessageBox.Show("Lỗi!");
            }
        }


        private void txtMaHD_TextChanged(object sender, EventArgs e)
        {
            dgvCTHD.DataSource = modify.Table("select * from tblChiTietHD where MaHD ='" + txtMaHD + "'");
        }
    }
}
