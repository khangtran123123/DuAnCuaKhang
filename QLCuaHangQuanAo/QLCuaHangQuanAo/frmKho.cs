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
using static QLCuaHangQuanAo.frmKho;

namespace QLCuaHangQuanAo
{
    public partial class frmKho : Form
    {
        public frmKho()
        {
            InitializeComponent();
        }
        Modify modify=new Modify();
        private void frmKho_Load(object sender, EventArgs e)
        {
            dgvKho.DataSource = modify.Table("select * from tblKho");

            dgvKho.Columns[0].HeaderText = "Mã Sản Phẩm";
            dgvKho.Columns[0].Width = 80;
            dgvKho.Columns[1].HeaderText = "Tên Sản Phẩm";
            dgvKho.Columns[1].Width = 120;
            dgvKho.Columns[2].HeaderText = "Giá";
            dgvKho.Columns[2].Width = 80;
            dgvKho.Columns[3].HeaderText = "Số Lượng";
            dgvKho.Columns[3].Width = 70;
            dgvKho.Columns[4].HeaderText = "Loại";
            dgvKho.Columns[4].Width = 80;
            dgvKho.Columns[5].HeaderText = "Thương Hiệu";
            dgvKho.Columns[5].Width = 100;
            dgvKho.Columns[6].HeaderText = "Mã Nhà Cung Cấp";
            dgvKho.Columns[6].Width = 100;
            dgvKho.Columns[7].HeaderText = "Ngày Nhập";
            dgvKho.Columns[7].Width = 120;

        }

        private void dgvKho_CellClick(object sender, DataGridViewCellEventArgs e)
        {
            int i;
            i = dgvKho.CurrentRow.Index;
            txtMaSP.Text = dgvKho.Rows[i].Cells[0].Value.ToString();
            txtTenSP.Text = dgvKho.Rows[i].Cells[1].Value.ToString();
            txtGiaSP.Text = dgvKho.Rows[i].Cells[2].Value.ToString();
            txtSoLuongSP.Text = dgvKho.Rows[i].Cells[3].Value.ToString();
            txtLoaiSP.Text = dgvKho.Rows[i].Cells[4].Value.ToString();
            txtThuongHieu.Text = dgvKho.Rows[i].Cells[5].Value.ToString();
            txtMaNCC.Text = dgvKho.Rows[i].Cells[6].Value.ToString();
            dtpNgayNhap.Text = dgvKho.Rows[i].Cells[7].Value.ToString();
           
        }

        private void btnSua_Click(object sender, EventArgs e)
        {
            try
            {
                DialogResult result = MessageBox.Show("Bạn có chắc chắn muốn sửa không?", "Xác nhận", MessageBoxButtons.YesNo, MessageBoxIcon.Question);

                if (result == DialogResult.Yes)
                {
                    modify.Command("update tblKho set TenSP= N'" + txtTenSP.Text + "',GiaSP= N'" + txtGiaSP.Text + "',SoLuongSp='" + txtSoLuongSP.Text + "',LoaiSP='" + txtLoaiSP.Text + "',ThuongHieuSp='" + txtThuongHieu.Text + "',MaNCC='" + txtMaNCC.Text + "',NgayNhap='" + dtpNgayNhap.Text + "' where MaSP='" + txtMaSP.Text + "'");
                    dgvKho.DataSource = modify.Table("select * from tblKho");
                    MessageBox.Show("Dữ liệu đã được sửa.", "Thông báo");
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

        private void btnXoa_Click(object sender, EventArgs e)
        {
            try
            {
                DialogResult result = MessageBox.Show("Bạn có chắc chắn muốn xóa không?", "Xác nhận", MessageBoxButtons.YesNo, MessageBoxIcon.Question);

                if (result == DialogResult.Yes)
                {
                    modify.Command("delete from tblKho where MaSP='" + txtMaSP.Text + "'");
                    dgvKho.DataSource = modify.Table("select * from tblKho");
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
        //Tìm kiếm và lấy mã NCC

        private void btnThoat_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        private void btnTimKiem_Click(object sender, EventArgs e)
        {
            dgvKho.DataSource = modify.Table("select * from tblKho where MaNCC like '%" + txtTimThuongHieu.Text + "%'");
        }

        private void txtTimThuongHieu_TextChanged(object sender, EventArgs e)
        {
            dgvKho.DataSource = modify.Table("select * from tblKho where MaNCC like '%" + txtTimThuongHieu.Text + "%'");
        }
    }
}
