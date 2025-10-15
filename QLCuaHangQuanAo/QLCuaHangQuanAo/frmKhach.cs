using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace QLCuaHangQuanAo
{
    public partial class frmKhach : Form
    {
        public frmKhach()
        {
            InitializeComponent();
        }
        Modify modify=new Modify();

        private void frmKhach_Load(object sender, EventArgs e)
        {
            dgvKhach.DataSource = modify.Table("select * from tblKhach");

            dgvKhach.Columns[0].HeaderText = "Mã Khách";
            dgvKhach.Columns[0].Width = 150;
            dgvKhach.Columns[1].HeaderText = "Tên Khách";
            dgvKhach.Columns[1].Width = 250;
            dgvKhach.Columns[2].HeaderText = "Giới Tính";
            dgvKhach.Columns[2].Width = 200;
            dgvKhach.Columns[3].HeaderText = "Số Diện Thoại";
            dgvKhach.Columns[3].Width = 200;           
        }

        private void dgvKhach_CellClick(object sender, DataGridViewCellEventArgs e)
        {
            int i;
            i = dgvKhach.CurrentRow.Index;
            txtMaKhach.Text = dgvKhach.Rows[i].Cells[0].Value.ToString();
            txtTenKhach.Text = dgvKhach.Rows[i].Cells[1].Value.ToString();
            cbbGioiTinhKhach.Text = dgvKhach.Rows[i].Cells[2].Value.ToString();
            txtSDTKhach.Text = dgvKhach.Rows[i].Cells[3].Value.ToString();
           
        }

        private void btnThem_Click(object sender, EventArgs e)
        {
            try
            {
                modify.Command("insert into tblKhach values('" + txtMaKhach.Text + "', N'" + txtTenKhach.Text + "', N'" + cbbGioiTinhKhach.Text + "','" + txtSDTKhach.Text + "')");
                dgvKhach.DataSource = modify.Table("select * from tblKhach");
                MessageBox.Show("Đã Thêm Thành Công");
            }
            catch
            {
                MessageBox.Show("Mã Khách Không Được Trùng!");
            }
        }

        private void btnXoa_Click(object sender, EventArgs e)
        {
            try
            {
                DialogResult result = MessageBox.Show("Bạn có chắc chắn muốn xóa không?", "Xác nhận", MessageBoxButtons.YesNo, MessageBoxIcon.Question);

                if (result == DialogResult.Yes)
                {
                    modify.Command("delete from tblKhach where MaKhach='" + txtMaKhach.Text + "'");
                    dgvKhach.DataSource = modify.Table("select * from tblKhach");
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

        private void btnSua_Click(object sender, EventArgs e)
        {
            try
            {
                DialogResult result = MessageBox.Show("Bạn có chắc chắn muốn sửa không?", "Xác nhận", MessageBoxButtons.YesNo, MessageBoxIcon.Question);

                if (result == DialogResult.Yes)
                {
                    modify.Command("update tblKhach set TenKhach= N'" + txtTenKhach.Text + "',GioiTinhKhach= N'" + cbbGioiTinhKhach.Text + "',SDTKhach='" + txtSDTKhach.Text + "' where MaKhach='" + txtMaKhach.Text + "'");
                    dgvKhach.DataSource = modify.Table("select * from tblKhach");
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

        private void btnThoat_Click(object sender, EventArgs e)
        {
            this.Close();
        }
    }
}
