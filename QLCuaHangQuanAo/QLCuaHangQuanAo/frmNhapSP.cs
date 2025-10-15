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

namespace QLCuaHangQuanAo
{
    public partial class frmNhapSP : Form
    {
        public frmNhapSP()
        {
            InitializeComponent();
            LoadMaNCC();
        }
        Modify modify=new Modify();
        private void frmNhapSP_Load(object sender, EventArgs e)
        {
            dgvNhapSP.DataSource = modify.Table("select * from tblKho");

            dgvNhapSP.Columns[0].HeaderText = "Mã Sản Phẩm";
            dgvNhapSP.Columns[0].Width = 100;
            dgvNhapSP.Columns[1].HeaderText = "Tên Sản Phẩm";
            dgvNhapSP.Columns[1].Width = 180;
            dgvNhapSP.Columns[2].HeaderText = "Giá";
            dgvNhapSP.Columns[2].Width = 100;
            dgvNhapSP.Columns[3].HeaderText = "Số Lượng";
            dgvNhapSP.Columns[3].Width = 100;
            dgvNhapSP.Columns[4].HeaderText = "Loại";
            dgvNhapSP.Columns[4].Width = 100;
            dgvNhapSP.Columns[5].HeaderText = "Thương Hiệu";
            dgvNhapSP.Columns[5].Width = 150;
            dgvNhapSP.Columns[6].HeaderText = "Mã Nhà Cung Cấp";
            dgvNhapSP.Columns[6].Width = 150;
            dgvNhapSP.Columns[7].HeaderText = "Ngày Nhập";
            dgvNhapSP.Columns[7].Width = 150;
        }

        private void dgvNhapSP_CellClick(object sender, DataGridViewCellEventArgs e)
        {
            int i;
            i = dgvNhapSP.CurrentRow.Index;
            txtMaSP.Text = dgvNhapSP.Rows[i].Cells[0].Value.ToString();
            txtTenSP.Text = dgvNhapSP.Rows[i].Cells[1].Value.ToString();
            txtGiaSP.Text = dgvNhapSP.Rows[i].Cells[2].Value.ToString();
            txtSoLuongSP.Text = dgvNhapSP.Rows[i].Cells[3].Value.ToString();
            txtLoaiSP.Text = dgvNhapSP.Rows[i].Cells[4].Value.ToString();
            txtThuongHieu.Text = dgvNhapSP.Rows[i].Cells[5].Value.ToString();
            cbbMaNCC.Text = dgvNhapSP.Rows[i].Cells[6].Value.ToString();
            dtpNgayNhap.Text = dgvNhapSP.Rows[i].Cells[7].Value.ToString();
        }

        private void LoadMaNCC()//ccb MaNCC
        {

            string query = "SELECT MaNCC FROM tblNCC";

            List<string> maNCCList = new List<string>();

            using (SqlConnection connection = Connection.GetSqlConnection())
            {
                using (SqlCommand command = new SqlCommand(query, connection))
                {
                    connection.Open();
                    SqlDataReader reader = command.ExecuteReader();

                    while (reader.Read())
                    {
                        maNCCList.Add(reader["MaNCC"].ToString());
                    }
                }
            }

            cbbMaNCC.DataSource = maNCCList;
        }

        private void btnNhap_Click(object sender, EventArgs e)
        {
            try
            {
                modify.Command("insert into tblKho values(N'" + txtMaSP.Text + "',N'" + txtTenSP.Text + "', N'" + txtGiaSP.Text + "', N'" + txtSoLuongSP.Text + "','" + txtLoaiSP.Text + "','" + txtThuongHieu.Text + "',N'" + cbbMaNCC.Text + "','" + dtpNgayNhap.Text + "')");
                dgvNhapSP.DataSource = modify.Table("select * from tblKho");
                MessageBox.Show("Đã Thêm Thành Công");
            }
            catch
            {
                MessageBox.Show("Lỗi!");
            }
        }

       
    }
}
