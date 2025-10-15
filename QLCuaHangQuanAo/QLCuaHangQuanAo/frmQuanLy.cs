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
    public partial class frmQuanLy : Form
    {
        public frmQuanLy()
        {
            InitializeComponent();
        }
        Modify modify=new Modify();
      
        private void frmQuanLy_Load(object sender, EventArgs e)
        {
            dgvQuanLy.DataSource = modify.Table("select * from tblQL");
            
            dgvQuanLy.Columns[0].HeaderText = "Mã Quản Lý";
            dgvQuanLy.Columns[0].Width = 100;
            dgvQuanLy.Columns[1].HeaderText = "Tên Quản Lý";
            dgvQuanLy.Columns[1].Width = 200;
            dgvQuanLy.Columns[2].HeaderText = "Giới Tính";
            dgvQuanLy.Columns[2].Width = 150;
            dgvQuanLy.Columns[3].HeaderText = "Số Diện Thoại";
            dgvQuanLy.Columns[3].Width = 150;
            dgvQuanLy.Columns[4].HeaderText = "Mật Khẩu";
            dgvQuanLy.Columns[4].Width = 200;
            dgvQuanLy.Columns[5].HeaderText = "Gmail";
            dgvQuanLy.Columns[5].Width = 350;

        }

        private void dgvQuanLy_CellClick(object sender, DataGridViewCellEventArgs e)
        {
            int i;
            i = dgvQuanLy.CurrentRow.Index;
            txtMaQL.Text = dgvQuanLy.Rows[i].Cells[0].Value.ToString();
            txtTenQL.Text = dgvQuanLy.Rows[i].Cells[1].Value.ToString();
            cbbGioiTinhQL.Text = dgvQuanLy.Rows[i].Cells[2].Value.ToString();            
            txtSDTQL.Text = dgvQuanLy.Rows[i].Cells[3].Value.ToString();
            txtMatKhauQL.Text = dgvQuanLy.Rows[i].Cells[4].Value.ToString();
            txtGmail.Text= dgvQuanLy.Rows[i].Cells[5].Value.ToString();
        }

        private void btnThem_Click(object sender, EventArgs e)
        {      
            try
            {
                modify.Command("insert into tblQL values('" + txtMaQL.Text + "', N'" + txtTenQL.Text + "', N'" + cbbGioiTinhQL.Text + "','" + txtSDTQL.Text + "','" + txtMatKhauQL.Text + "',N'" + txtGmail.Text + "')");
                dgvQuanLy.DataSource = modify.Table("select * from tblQL");
                MessageBox.Show("Đã Thêm Thành Công");
            }
            catch 
            {
                MessageBox.Show("Mã Quản Lý Không Được Trùng!");
            }
            
        }

        private void btnSua_Click(object sender, EventArgs e)
        {
            try
            {


                DialogResult result = MessageBox.Show("Bạn có chắc chắn muốn sửa không?", "Xác nhận", MessageBoxButtons.YesNo, MessageBoxIcon.Question);

                if (result == DialogResult.Yes)
                {
                    modify.Command("update tblQL set TenQL= N'" + txtTenQL.Text + "',GioiTinhQL= N'" + cbbGioiTinhQL.Text + "',SDTQL='" + txtSDTQL.Text + "',MatKhauQL='" + txtMatKhauQL.Text + "',Email = '" + txtGmail.Text + "' where MaQL='" + txtMaQL.Text + "'");
                    dgvQuanLy.DataSource = modify.Table("select * from tblQL");
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
                    modify.Command("delete from tblQL where MaQL='" + txtMaQL.Text + "'");
                    dgvQuanLy.DataSource = modify.Table("select * from tblQL");
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

        private void btnThoat_Click(object sender, EventArgs e)
        {
            this.Close();
        }
    }
}
