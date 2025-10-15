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
    public partial class frmBanHang : Form
    {
        public frmBanHang()
        {
            InitializeComponent();
            LoadMaHD();
            LoadMaSP();
            LoadMaQL();
            LoadMaKhach();
            txtDonGia.ReadOnly = true;
            txtGiamGia.ReadOnly = true;
            txtThanhTien.ReadOnly = true;
            txtTongTien.ReadOnly = true;
    
        }
        Modify modify = new Modify();
       

        private void frmBanHang_Load(object sender, EventArgs e)
        {
            dgvHoaDon.DataSource = modify.Table("select * from tblHoaDon");

            dgvHoaDon.Columns[0].HeaderText = "Mã Hóa Đơn";
            dgvHoaDon.Columns[0].Width = 80;
            dgvHoaDon.Columns[1].HeaderText = "Mã Quản Lý";
            dgvHoaDon.Columns[1].Width = 80;
            dgvHoaDon.Columns[2].HeaderText = "Mã Khách";
            dgvHoaDon.Columns[2].Width = 80;
            dgvHoaDon.Columns[3].HeaderText = "Giảm Giá";
            dgvHoaDon.Columns[3].Width = 80;
            dgvHoaDon.Columns[4].HeaderText = "Tổng Tiền";
            dgvHoaDon.Columns[4].Width = 80;
            dgvHoaDon.Columns[5].HeaderText = "Ngày Bán";
            dgvHoaDon.Columns[5].Width = 120;
        }

        private void dgvHoaDon_CellClick(object sender, DataGridViewCellEventArgs e)
        {
            int i;
            i = dgvHoaDon.CurrentRow.Index;
            txtMaHD.Text = dgvHoaDon.Rows[i].Cells[0].Value.ToString();
            cbbMaQL.Text = dgvHoaDon.Rows[i].Cells[1].Value.ToString();
            cbbMaKhach.Text = dgvHoaDon.Rows[i].Cells[2].Value.ToString();
            txtGiamGia.Text = dgvHoaDon.Rows[i].Cells[3].Value.ToString();
            txtTongTien.Text = dgvHoaDon.Rows[i].Cells[4].Value.ToString();
            dtpNgayBan.Text = dgvHoaDon.Rows[i].Cells[5].Value.ToString();
        }

        private void btnTaoHD_Click(object sender, EventArgs e)
        {
            try
            {
                modify.Command("insert into tblHoaDon values('" + txtMaHD.Text + "', '" + cbbMaQL.Text + "', '" + cbbMaKhach.Text + "','" + txtGiamGia.Text + "','" + txtTongTien.Text + "','" + dtpNgayBan.Text + "')");
                dgvHoaDon.DataSource = modify.Table("select * from tblHoaDon");
                MessageBox.Show("Đã Thêm Thành Công");
            }
            catch
            {
                MessageBox.Show("Lỗi!");
            }
        }

        private void btnXoaHD_Click(object sender, EventArgs e)
        {
            try
            {
                DialogResult result = MessageBox.Show("Bạn có chắc chắn muốn xóa không?", "Xác nhận", MessageBoxButtons.YesNo, MessageBoxIcon.Question);

                if (result == DialogResult.Yes)
                {
                    modify.Command("delete from tblHoaDon where MaHD='" + txtMaHD.Text + "'");
                    dgvHoaDon.DataSource = modify.Table("select * from tblHoaDon");
                    MessageBox.Show("Dữ liệu đã bị xóa.", "Thông báo");
                }
                else
                {
                    MessageBox.Show("Hủy xóa dữ liệu.", "Thông báo");
                }

            }
            catch (Exception ex)
            {
                MessageBox.Show($"Error: {ex.Message}");
            }
        }

        //chi tiết hóa đơn

        private void LoadMaHD()//ccb MaHD lấy dữ liệu từ table hd
        {
           
            string query = "SELECT MaHD FROM tblHoaDon";

            List<string> maHDList = new List<string>();

            using (SqlConnection connection = Connection.GetSqlConnection())
            {
                using (SqlCommand command = new SqlCommand(query, connection))
                {
                    connection.Open();
                    SqlDataReader reader = command.ExecuteReader();

                    while (reader.Read())
                    {
                        maHDList.Add(reader["MaHD"].ToString());
                    }
                }
            }

            cbbMaHD.DataSource = maHDList;
        }

        private void LoadMaSP()//ccb MaSP lấy dữ liệu từ table Kho
        {
            string query = "SELECT MaSP FROM tblKho";

            List<string> maSPList = new List<string>();

            using (SqlConnection connection = Connection.GetSqlConnection())
            {
                using (SqlCommand command = new SqlCommand(query, connection))
                {
                    connection.Open();
                    SqlDataReader reader = command.ExecuteReader();

                    while (reader.Read())
                    {
                        maSPList.Add(reader["MaSP"].ToString());
                    }
                }
            }

            cbbMaSP.DataSource = maSPList;

        }

        private void LoadMaQL()//ccb MaQL lấy dữ liệu từ table ql
        {
            string query = "SELECT MaQL FROM tblQL";

            List<string> maQLList = new List<string>();

            using (SqlConnection connection =Connection.GetSqlConnection())
            {
                using (SqlCommand command = new SqlCommand(query, connection))
                {
                    connection.Open();
                    SqlDataReader reader = command.ExecuteReader();

                    while (reader.Read())
                    {
                        maQLList.Add(reader["MaQL"].ToString());
                    }
                }
            }

            cbbMaQL.DataSource = maQLList;
        }

        private void LoadMaKhach()//ccb Makhach
        {

            string query = "SELECT MaKhach FROM tblKhach";

            List<string> maKhachList = new List<string>();

            using (SqlConnection connection = Connection.GetSqlConnection())
            {
                using (SqlCommand command = new SqlCommand(query, connection))
                {
                    connection.Open();
                    SqlDataReader reader = command.ExecuteReader();

                    while (reader.Read())
                    {
                        maKhachList.Add(reader["MaKhach"].ToString());
                    }
                }
            }

            cbbMaKhach.DataSource = maKhachList;
        }

        // hien don gia 
        private void LoadDonGia()
        {

            string selectedMaSP = cbbMaSP.SelectedItem.ToString();

            string query1 = "SELECT GiaSP FROM tblKho WHERE MaSP = @MaSP";

            using (SqlConnection connection = Connection.GetSqlConnection())
            {
                SqlCommand command = new SqlCommand(query1, connection);
                command.Parameters.AddWithValue("@MaSP", selectedMaSP);

                try
                {
                    connection.Open();
                    object result = command.ExecuteScalar();

                    if (result != null)
                    {
                        txtDonGia.Text = result.ToString();
                    }
                    else
                    {
                        txtDonGia.Text = "Không tìm thấy!";
                    }
                }
                catch (Exception ex)
                {
                    MessageBox.Show($"Error: {ex.Message}");
                }
            }
        }

        private void LoadSoLuong()
        {

            string selectedMaSP = cbbMaSP.SelectedItem.ToString();

            string query1 = "SELECT SoLuongSP FROM tblKho WHERE MaSP = @MaSP";

            using (SqlConnection connection = Connection.GetSqlConnection()) 
            {
                SqlCommand command = new SqlCommand(query1,connection);
                command.Parameters.AddWithValue("@MaSP", selectedMaSP);

                try
                {
                    connection.Open();
                    object result = command.ExecuteScalar();

                    if (result != null)
                    {
                        txtSoLuong.Text = result.ToString();
                    }
                    
                }
                catch (Exception ex)
                {
                    MessageBox.Show($"Error: {ex.Message}");
                }
            }
        }

        //Lấy sl trong kho để đi so sánh với sl khách mua hàng
        public int LaySoLuong(string maSP)
        {
            int soLuongTonKho = 0;

            using (SqlConnection conn = Connection.GetSqlConnection())
            {
                conn.Open();
                using (SqlCommand cmd = new SqlCommand("SELECT SoLuongSP FROM tblKho WHERE MaSP = @maSP", conn))
                {
                    cmd.Parameters.AddWithValue("@maSP", maSP);
                    using (SqlDataReader reader = cmd.ExecuteReader())
                    {
                        if (reader.Read())
                        {
                            soLuongTonKho = (int)reader["SoLuongSP"];
                        }
                    }
                }
            }

            return soLuongTonKho;
        }

        //lấy tổng tiền tron csdl để xem hd đó đã bán hay chưa
        public double LayTongTien(string maHD)
        {
            double TongTien = 0;

            using (SqlConnection conn = Connection.GetSqlConnection())
            {
                conn.Open();
                using (SqlCommand cmd = new SqlCommand("SELECT TongTien FROM tblHoaDon WHERE MaHD = @maHD", conn))
                {
                    cmd.Parameters.AddWithValue("@maHD", maHD);
                    using (SqlDataReader reader = cmd.ExecuteReader())
                    {
                        if (reader.Read())
                        {
                            TongTien = (double)reader["TongTien"];
                        }
                    }
                }
            }

            return TongTien;
        }

        private void btnReset_Click(object sender, EventArgs e)
        {
            LoadMaHD();
            modify.Command("update tblHoaDon set MaQL= N'" + cbbMaQL.Text + "',MaKhach= N'" + cbbMaKhach.Text + "',GiamGia='" + txtGiamGia.Text + "',TongTien='" + txtTongTien.Text + "',NgayBan='" + dtpNgayBan.Text + "'  where MaHD='" + txtMaHD.Text + "'");
            dgvHoaDon.DataSource = modify.Table("select * from tblHoaDon");
          
        }

        private void cbbMaSP_SelectedIndexChanged(object sender, EventArgs e)
        {
            LoadDonGia() ;
            LoadSoLuong();
        }

        private void txtSoLuong_TextChanged(object sender, EventArgs e)
        {
            TinhThanhTien();         
        }

        private DataTable dtSanPham = new DataTable();

        private void btnThemSP_Click(object sender, EventArgs e)
        {
            string maHD = txtMaHD.Text;
            double TongTien = LayTongTien(maHD);
            string MaHD = cbbMaHD.Text;
            if (TongTien > 0)
            {
                MessageBox.Show("Không thể thêm sản phẩm vào hóa đơn đã bán rồi!");
                return;
            }

            // Tạo một dòng mới và tính toán ThanhTien ngay lập tức
            if(dtSanPham.Columns.Count==0)
            {
                dtSanPham.Columns.Add("MaHD");
                dtSanPham.Columns.Add("MaSP");
                dtSanPham.Columns.Add("DonGia");
                dtSanPham.Columns.Add("SoLuong");
                dtSanPham.Columns.Add("ThanhTien");
            }
           

            DataRow dr = dtSanPham.NewRow();
            dr["MaHD"] = cbbMaHD.Text;
            dr["MaSP"] = cbbMaSP.Text;
            dr["DonGia"] = Convert.ToDouble(txtDonGia.Text);
            dr["SoLuong"] = Convert.ToDouble(txtSoLuong.Text);
            dr["ThanhTien"] = Convert.ToDouble(txtThanhTien.Text);

            // Kiểm tra sản phẩm đã tồn tại chưa 
            bool productExists = false;
            foreach (DataRow row in dtSanPham.Rows)
            {
                if (row["MaSP"].ToString() == cbbMaSP.Text)
                {
                    productExists = true;
                    break;
                }
            }

            if (productExists)
            {
                MessageBox.Show("Sản phẩm đã có trong hóa đơn!");
            }
            else
            {
                dtSanPham.Rows.Add(dr);
                TinhTongTien(maHD); // Cập nhật tổng tiền
                dgvChiTietHD.DataSource = dtSanPham;
            }
        }

        //Tính thành tiền 
        private void TinhThanhTien()
        {
            try
            {
                string MaHD = cbbMaHD.Text;
                string MaSP = cbbMaSP.SelectedItem.ToString();
                int SoLuongNhap = int.Parse(txtSoLuong.Text);
                int SoLuongTon = LaySoLuong(MaSP);

                if (SoLuongNhap > SoLuongTon || SoLuongNhap < 1)
                {
                    MessageBox.Show("Ko đủ số lượng sản phẩm để bán hoặc số lượng không được <1!");
                    int SL = 1;
                    txtSoLuong.Text = SL.ToString();
                }

                double donGia = double.Parse(txtDonGia.Text);
                int soLuong = int.Parse(txtSoLuong.Text);

                double thanhTien = donGia * soLuong;
                txtThanhTien.Text = thanhTien.ToString();

            }
            catch (Exception ex)
            {
                MessageBox.Show($"Error: {ex.Message}");
            }

        }

        //txt TongTien cuaHD
        private void TinhTongTien(string maHD)
        {
            double tongTien = 0;
            int soLuongMua = 0;

            // Lọc các hàng có cùng MaHD
            var rows = dtSanPham.Select($"MaHD = '{maHD}'");

            // Tính tổng các giá trị ThanhTien
            foreach (DataRow row in rows)
            {
                tongTien += Convert.ToDouble(row["ThanhTien"]);
                soLuongMua += Convert.ToInt32(row["SoLuong"]);
            }

            // Hiển thị tổng tiền vào TextBox
            if (soLuongMua < 4)
            {
                float giamGia = 0;
                txtGiamGia.Text = giamGia.ToString();
                tongTien = tongTien * (1);

            }
            else if (soLuongMua <= 8)
            {
                float giamGia = 10;
                txtGiamGia.Text = giamGia.ToString();
                tongTien = tongTien * 0.9;  //giảm 10 %
            }
            else
            {
                float giamGia = 20;
                txtGiamGia.Text = giamGia.ToString();
                tongTien = tongTien * 0.8; //giảm 20 %
            }

            txtTongTien.Text = tongTien.ToString();
        }

        private void btnXoaSP_Click(object sender, EventArgs e)
        {
            if (dgvChiTietHD.SelectedRows.Count > 0)
            {
                String MaHD=txtMaHD.Text;
                // Lấy chỉ số của hàng được chọn
                int rowIndex = dgvChiTietHD.SelectedRows[0].Index;
                dtSanPham.Rows.RemoveAt(rowIndex);
                dgvChiTietHD.DataSource = dtSanPham;

                TinhTongTien(MaHD);

            }
            else
            {
                MessageBox.Show("Vui lòng chọn sản phẩm cần xóa!", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Warning);
            }
        }

        private void btnBan_Click(object sender, EventArgs e)
        {
            // Kiểm tra xem có dữ liệu trong DataTable không
            if (dtSanPham.Rows.Count > 0)
            {
                using (SqlConnection conn = Connection.GetSqlConnection())
                {
                    conn.Open();
                    SqlTransaction transaction = conn.BeginTransaction();

                    try
                    {
                        // Lặp qua từng hàng trong DataTable
                        foreach (DataRow row in dtSanPham.Rows)
                        {
                            // Lấy thông tin từ DataRow
                            string maSP = row["MaSP"].ToString();
                            int soLuongBan = Convert.ToInt32(row["SoLuong"]);

                            // Cập nhật số lượng tồn kho trong tblKho
                            SqlCommand cmdUpdateKho = new SqlCommand("UPDATE tblKho SET SoLuongSP = SoLuongSP - @soLuong WHERE MaSP = @maSP", conn);
                            cmdUpdateKho.Parameters.AddWithValue("@soLuong", soLuongBan);
                            cmdUpdateKho.Parameters.AddWithValue("@maSP", maSP);
                            cmdUpdateKho.Transaction = transaction;
                            cmdUpdateKho.ExecuteNonQuery();

                            // Thêm dữ liệu vào tblCTHD
                            SqlCommand cmdInsertCTHD = new SqlCommand("INSERT INTO tblChiTietHD (MaHD, MaSP, SoLuong, DonGia,ThanhTien) VALUES (@maHD, @maSP, @soLuong, @donGia, @thanhTien)", conn);
                            cmdInsertCTHD.Parameters.AddWithValue("@maHD", txtMaHD.Text); 
                            cmdInsertCTHD.Parameters.AddWithValue("@maSP", maSP);
                            cmdInsertCTHD.Parameters.AddWithValue("@soLuong", soLuongBan);
                            cmdInsertCTHD.Parameters.AddWithValue("@donGia", Convert.ToDouble(row["DonGia"]));
                            cmdInsertCTHD.Parameters.AddWithValue("@thanhTien", Convert.ToDouble(row["ThanhTien"]));
                            cmdInsertCTHD.Transaction = transaction;
                            cmdInsertCTHD.ExecuteNonQuery();
                           
                        }

                        modify.Command("update tblHoaDon set MaQL= N'" + cbbMaQL.Text + "',MaKhach= N'" + cbbMaKhach.Text + "',GiamGia='" + txtGiamGia.Text + "',TongTien='" + txtTongTien.Text + "',NgayBan='" + dtpNgayBan.Text + "'  where MaHD='" + txtMaHD.Text + "'");

                        transaction.Commit();
                        MessageBox.Show("Lưu hóa đơn thành công!");

                        // Làm sạch DataTable và DataGridView sau khi lưu
                        dtSanPham.Rows.Clear();
                        dgvChiTietHD.DataSource = dtSanPham;
                    }
                    catch (Exception ex)
                    {
                        transaction.Rollback();
                        MessageBox.Show("Lỗi khi lưu hóa đơn: " + ex.Message);
                    }
                }
            }
            else
            {
                MessageBox.Show("Không có sản phẩm nào để bán!");
            }
        }

        
    }
}
