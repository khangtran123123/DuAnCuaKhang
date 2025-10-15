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
    public partial class frmNCC : Form
    {
        public frmNCC()
        {
            InitializeComponent();
        }
        Modify modify = new Modify();
        private void frmNCC_Load(object sender, EventArgs e)
        {
            dgvNCC.DataSource = modify.Table("select * from tblNCC");

            dgvNCC.Columns[0].HeaderText = "Mã Nhà Cung Cấp";
            dgvNCC.Columns[0].Width = 150;
            dgvNCC.Columns[1].HeaderText = "Tên Nhà Cung Cấp";
            dgvNCC.Columns[1].Width = 250;
            dgvNCC.Columns[2].HeaderText = "Địa Chỉ";
            dgvNCC.Columns[2].Width = 200;
            dgvNCC.Columns[3].HeaderText = "Số Diện Thoại";
            dgvNCC.Columns[3].Width = 200;
        }

        private void dgvNCC_CellClick(object sender, DataGridViewCellEventArgs e)
        {
            int i;
            i = dgvNCC.CurrentRow.Index;
            txtMaNCC.Text = dgvNCC.Rows[i].Cells[0].Value.ToString();
            txtTenNCC.Text = dgvNCC.Rows[i].Cells[1].Value.ToString();
            txtDiaChiNCC.Text = dgvNCC.Rows[i].Cells[2].Value.ToString();
            txtSDTNCC.Text = dgvNCC.Rows[i].Cells[3].Value.ToString();
        }

        private void btnThem_Click(object sender, EventArgs e)
        {
            try
            {
                modify.Command("insert into tblNCC values('" + txtMaNCC.Text + "', N'" + txtTenNCC.Text + "', N'" + txtDiaChiNCC.Text + "','" + txtSDTNCC.Text + "')");
                dgvNCC.DataSource = modify.Table("select * from tblNCC");
                MessageBox.Show("Đã Thêm Thành Công");
            }
            catch
            {
                MessageBox.Show("Mã Nhà Cung Cấp Không Được Trùng!");
            }
        }

        private void btnXoa_Click(object sender, EventArgs e)
        {
            try
            {
                DialogResult result = MessageBox.Show("Bạn có chắc chắn muốn xóa không?", "Xác nhận", MessageBoxButtons.YesNo, MessageBoxIcon.Question);

                if (result == DialogResult.Yes)
                {
                    modify.Command("delete from tblNCC where MaNCC='" + txtMaNCC.Text + "'");
                    dgvNCC.DataSource = modify.Table("select * from tblNCC");
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
                    modify.Command("update tblNCC set TenNCC= N'" + txtTenNCC.Text + "',DiaChiNCC= N'" + txtDiaChiNCC.Text + "',SDTNCC='" + txtSDTNCC.Text + "' where MaNCC='" + txtMaNCC.Text + "'");
                    dgvNCC.DataSource = modify.Table("select * from tblNCC");
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
