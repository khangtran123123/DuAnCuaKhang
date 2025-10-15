namespace QLCuaHangQuanAo
{
    partial class frmNhapSP
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            this.pnThongTinNhap = new System.Windows.Forms.Panel();
            this.cbbMaNCC = new System.Windows.Forms.ComboBox();
            this.dtpNgayNhap = new System.Windows.Forms.DateTimePicker();
            this.btnNhap = new System.Windows.Forms.Button();
            this.txtThuongHieu = new System.Windows.Forms.TextBox();
            this.txtLoaiSP = new System.Windows.Forms.TextBox();
            this.txtSoLuongSP = new System.Windows.Forms.TextBox();
            this.txtGiaSP = new System.Windows.Forms.TextBox();
            this.txtTenSP = new System.Windows.Forms.TextBox();
            this.txtMaSP = new System.Windows.Forms.TextBox();
            this.lblMaNCC = new System.Windows.Forms.Label();
            this.lblNgayNhap = new System.Windows.Forms.Label();
            this.lblThuongHieu = new System.Windows.Forms.Label();
            this.lblLoai = new System.Windows.Forms.Label();
            this.lblSoLuong = new System.Windows.Forms.Label();
            this.lblGiaSP = new System.Windows.Forms.Label();
            this.lblTenSP = new System.Windows.Forms.Label();
            this.lblMaSP = new System.Windows.Forms.Label();
            this.lblTieuDe = new System.Windows.Forms.Label();
            this.pnHienThi = new System.Windows.Forms.Panel();
            this.dgvNhapSP = new System.Windows.Forms.DataGridView();
            this.pbAnh = new System.Windows.Forms.PictureBox();
            this.pnThongTinNhap.SuspendLayout();
            this.pnHienThi.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.dgvNhapSP)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.pbAnh)).BeginInit();
            this.SuspendLayout();
            // 
            // pnThongTinNhap
            // 
            this.pnThongTinNhap.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(192)))), ((int)(((byte)(255)))), ((int)(((byte)(255)))));
            this.pnThongTinNhap.Controls.Add(this.pbAnh);
            this.pnThongTinNhap.Controls.Add(this.cbbMaNCC);
            this.pnThongTinNhap.Controls.Add(this.dtpNgayNhap);
            this.pnThongTinNhap.Controls.Add(this.btnNhap);
            this.pnThongTinNhap.Controls.Add(this.txtThuongHieu);
            this.pnThongTinNhap.Controls.Add(this.txtLoaiSP);
            this.pnThongTinNhap.Controls.Add(this.txtSoLuongSP);
            this.pnThongTinNhap.Controls.Add(this.txtGiaSP);
            this.pnThongTinNhap.Controls.Add(this.txtTenSP);
            this.pnThongTinNhap.Controls.Add(this.txtMaSP);
            this.pnThongTinNhap.Controls.Add(this.lblMaNCC);
            this.pnThongTinNhap.Controls.Add(this.lblNgayNhap);
            this.pnThongTinNhap.Controls.Add(this.lblThuongHieu);
            this.pnThongTinNhap.Controls.Add(this.lblLoai);
            this.pnThongTinNhap.Controls.Add(this.lblSoLuong);
            this.pnThongTinNhap.Controls.Add(this.lblGiaSP);
            this.pnThongTinNhap.Controls.Add(this.lblTenSP);
            this.pnThongTinNhap.Controls.Add(this.lblMaSP);
            this.pnThongTinNhap.Controls.Add(this.lblTieuDe);
            this.pnThongTinNhap.Dock = System.Windows.Forms.DockStyle.Top;
            this.pnThongTinNhap.Location = new System.Drawing.Point(0, 0);
            this.pnThongTinNhap.Name = "pnThongTinNhap";
            this.pnThongTinNhap.Size = new System.Drawing.Size(1184, 264);
            this.pnThongTinNhap.TabIndex = 0;
            // 
            // cbbMaNCC
            // 
            this.cbbMaNCC.FormattingEnabled = true;
            this.cbbMaNCC.Location = new System.Drawing.Point(931, 106);
            this.cbbMaNCC.Name = "cbbMaNCC";
            this.cbbMaNCC.Size = new System.Drawing.Size(195, 21);
            this.cbbMaNCC.TabIndex = 20;
            // 
            // dtpNgayNhap
            // 
            this.dtpNgayNhap.Format = System.Windows.Forms.DateTimePickerFormat.Short;
            this.dtpNgayNhap.Location = new System.Drawing.Point(931, 161);
            this.dtpNgayNhap.Name = "dtpNgayNhap";
            this.dtpNgayNhap.Size = new System.Drawing.Size(195, 20);
            this.dtpNgayNhap.TabIndex = 19;
            // 
            // btnNhap
            // 
            this.btnNhap.Font = new System.Drawing.Font("Microsoft Sans Serif", 9F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.btnNhap.Location = new System.Drawing.Point(852, 206);
            this.btnNhap.Name = "btnNhap";
            this.btnNhap.Size = new System.Drawing.Size(275, 46);
            this.btnNhap.TabIndex = 18;
            this.btnNhap.Text = "Nhập Sản Phẩm";
            this.btnNhap.UseVisualStyleBackColor = true;
            this.btnNhap.Click += new System.EventHandler(this.btnNhap_Click);
            // 
            // txtThuongHieu
            // 
            this.txtThuongHieu.Location = new System.Drawing.Point(646, 223);
            this.txtThuongHieu.Name = "txtThuongHieu";
            this.txtThuongHieu.Size = new System.Drawing.Size(197, 20);
            this.txtThuongHieu.TabIndex = 15;
            // 
            // txtLoaiSP
            // 
            this.txtLoaiSP.Location = new System.Drawing.Point(646, 164);
            this.txtLoaiSP.Name = "txtLoaiSP";
            this.txtLoaiSP.Size = new System.Drawing.Size(197, 20);
            this.txtLoaiSP.TabIndex = 14;
            // 
            // txtSoLuongSP
            // 
            this.txtSoLuongSP.Location = new System.Drawing.Point(646, 105);
            this.txtSoLuongSP.Name = "txtSoLuongSP";
            this.txtSoLuongSP.Size = new System.Drawing.Size(197, 20);
            this.txtSoLuongSP.TabIndex = 13;
            // 
            // txtGiaSP
            // 
            this.txtGiaSP.Location = new System.Drawing.Point(345, 223);
            this.txtGiaSP.Name = "txtGiaSP";
            this.txtGiaSP.Size = new System.Drawing.Size(197, 20);
            this.txtGiaSP.TabIndex = 12;
            // 
            // txtTenSP
            // 
            this.txtTenSP.Location = new System.Drawing.Point(345, 164);
            this.txtTenSP.Name = "txtTenSP";
            this.txtTenSP.Size = new System.Drawing.Size(197, 20);
            this.txtTenSP.TabIndex = 11;
            // 
            // txtMaSP
            // 
            this.txtMaSP.Location = new System.Drawing.Point(345, 105);
            this.txtMaSP.Name = "txtMaSP";
            this.txtMaSP.Size = new System.Drawing.Size(197, 20);
            this.txtMaSP.TabIndex = 10;
            // 
            // lblMaNCC
            // 
            this.lblMaNCC.AutoSize = true;
            this.lblMaNCC.Font = new System.Drawing.Font("Microsoft Sans Serif", 9F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.lblMaNCC.Location = new System.Drawing.Point(849, 106);
            this.lblMaNCC.Name = "lblMaNCC";
            this.lblMaNCC.Size = new System.Drawing.Size(56, 15);
            this.lblMaNCC.TabIndex = 8;
            this.lblMaNCC.Text = "Mã NCC:";
            // 
            // lblNgayNhap
            // 
            this.lblNgayNhap.AutoSize = true;
            this.lblNgayNhap.Font = new System.Drawing.Font("Microsoft Sans Serif", 9F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.lblNgayNhap.Location = new System.Drawing.Point(849, 165);
            this.lblNgayNhap.Name = "lblNgayNhap";
            this.lblNgayNhap.Size = new System.Drawing.Size(71, 15);
            this.lblNgayNhap.TabIndex = 7;
            this.lblNgayNhap.Text = "Ngày Nhập:";
            // 
            // lblThuongHieu
            // 
            this.lblThuongHieu.AutoSize = true;
            this.lblThuongHieu.Font = new System.Drawing.Font("Microsoft Sans Serif", 9F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.lblThuongHieu.Location = new System.Drawing.Point(557, 224);
            this.lblThuongHieu.Name = "lblThuongHieu";
            this.lblThuongHieu.Size = new System.Drawing.Size(81, 15);
            this.lblThuongHieu.TabIndex = 6;
            this.lblThuongHieu.Text = "Thương Hiệu:";
            // 
            // lblLoai
            // 
            this.lblLoai.AutoSize = true;
            this.lblLoai.Font = new System.Drawing.Font("Microsoft Sans Serif", 9F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.lblLoai.Location = new System.Drawing.Point(557, 165);
            this.lblLoai.Name = "lblLoai";
            this.lblLoai.Size = new System.Drawing.Size(34, 15);
            this.lblLoai.TabIndex = 5;
            this.lblLoai.Text = "Loại:";
            // 
            // lblSoLuong
            // 
            this.lblSoLuong.AutoSize = true;
            this.lblSoLuong.Font = new System.Drawing.Font("Microsoft Sans Serif", 9F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.lblSoLuong.Location = new System.Drawing.Point(557, 106);
            this.lblSoLuong.Name = "lblSoLuong";
            this.lblSoLuong.Size = new System.Drawing.Size(63, 15);
            this.lblSoLuong.TabIndex = 4;
            this.lblSoLuong.Text = "Số Lượng:";
            // 
            // lblGiaSP
            // 
            this.lblGiaSP.AutoSize = true;
            this.lblGiaSP.Font = new System.Drawing.Font("Microsoft Sans Serif", 9F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.lblGiaSP.Location = new System.Drawing.Point(250, 224);
            this.lblGiaSP.Name = "lblGiaSP";
            this.lblGiaSP.Size = new System.Drawing.Size(90, 15);
            this.lblGiaSP.TabIndex = 3;
            this.lblGiaSP.Text = "Giá Sản Phẩm:";
            // 
            // lblTenSP
            // 
            this.lblTenSP.AutoSize = true;
            this.lblTenSP.Font = new System.Drawing.Font("Microsoft Sans Serif", 9F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.lblTenSP.Location = new System.Drawing.Point(250, 165);
            this.lblTenSP.Name = "lblTenSP";
            this.lblTenSP.Size = new System.Drawing.Size(92, 15);
            this.lblTenSP.TabIndex = 2;
            this.lblTenSP.Text = "Tên Sản Phẩm:";
            // 
            // lblMaSP
            // 
            this.lblMaSP.AutoSize = true;
            this.lblMaSP.Font = new System.Drawing.Font("Microsoft Sans Serif", 9F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.lblMaSP.Location = new System.Drawing.Point(250, 106);
            this.lblMaSP.Name = "lblMaSP";
            this.lblMaSP.Size = new System.Drawing.Size(89, 15);
            this.lblMaSP.TabIndex = 1;
            this.lblMaSP.Text = "Mã Sản Phẩm:";
            // 
            // lblTieuDe
            // 
            this.lblTieuDe.AutoSize = true;
            this.lblTieuDe.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(192)))), ((int)(((byte)(255)))), ((int)(((byte)(255)))));
            this.lblTieuDe.Font = new System.Drawing.Font("Microsoft Sans Serif", 21.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.lblTieuDe.Location = new System.Drawing.Point(519, 25);
            this.lblTieuDe.Name = "lblTieuDe";
            this.lblTieuDe.Size = new System.Drawing.Size(227, 33);
            this.lblTieuDe.TabIndex = 0;
            this.lblTieuDe.Text = "Nhập Sản Phẩm";
            this.lblTieuDe.TextAlign = System.Drawing.ContentAlignment.MiddleCenter;
            // 
            // pnHienThi
            // 
            this.pnHienThi.Controls.Add(this.dgvNhapSP);
            this.pnHienThi.Dock = System.Windows.Forms.DockStyle.Fill;
            this.pnHienThi.Location = new System.Drawing.Point(0, 264);
            this.pnHienThi.Name = "pnHienThi";
            this.pnHienThi.Size = new System.Drawing.Size(1184, 497);
            this.pnHienThi.TabIndex = 1;
            // 
            // dgvNhapSP
            // 
            this.dgvNhapSP.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            this.dgvNhapSP.Location = new System.Drawing.Point(69, 16);
            this.dgvNhapSP.Name = "dgvNhapSP";
            this.dgvNhapSP.Size = new System.Drawing.Size(1059, 439);
            this.dgvNhapSP.TabIndex = 0;
            this.dgvNhapSP.CellClick += new System.Windows.Forms.DataGridViewCellEventHandler(this.dgvNhapSP_CellClick);
            // 
            // pbAnh
            // 
            this.pbAnh.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.pbAnh.Image = global::QLCuaHangQuanAo.Properties.Resources.packaging__2_;
            this.pbAnh.Location = new System.Drawing.Point(21, 20);
            this.pbAnh.Name = "pbAnh";
            this.pbAnh.Size = new System.Drawing.Size(223, 238);
            this.pbAnh.TabIndex = 21;
            this.pbAnh.TabStop = false;
            // 
            // frmNhapSP
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(1184, 761);
            this.Controls.Add(this.pnHienThi);
            this.Controls.Add(this.pnThongTinNhap);
            this.MaximizeBox = false;
            this.MaximumSize = new System.Drawing.Size(1200, 800);
            this.MinimizeBox = false;
            this.MinimumSize = new System.Drawing.Size(1200, 800);
            this.Name = "frmNhapSP";
            this.Text = "frmNhapSP";
            this.Load += new System.EventHandler(this.frmNhapSP_Load);
            this.pnThongTinNhap.ResumeLayout(false);
            this.pnThongTinNhap.PerformLayout();
            this.pnHienThi.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.dgvNhapSP)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.pbAnh)).EndInit();
            this.ResumeLayout(false);

        }

        #endregion

        private System.Windows.Forms.Panel pnThongTinNhap;
        private System.Windows.Forms.Panel pnHienThi;
        private System.Windows.Forms.DataGridView dgvNhapSP;
        private System.Windows.Forms.Label lblTieuDe;
        private System.Windows.Forms.Label lblGiaSP;
        private System.Windows.Forms.Label lblTenSP;
        private System.Windows.Forms.Label lblMaSP;
        private System.Windows.Forms.Label lblSoLuong;
        private System.Windows.Forms.TextBox txtThuongHieu;
        private System.Windows.Forms.TextBox txtLoaiSP;
        private System.Windows.Forms.TextBox txtSoLuongSP;
        private System.Windows.Forms.TextBox txtGiaSP;
        private System.Windows.Forms.TextBox txtTenSP;
        private System.Windows.Forms.TextBox txtMaSP;
        private System.Windows.Forms.Label lblMaNCC;
        private System.Windows.Forms.Label lblNgayNhap;
        private System.Windows.Forms.Label lblThuongHieu;
        private System.Windows.Forms.Label lblLoai;
        private System.Windows.Forms.Button btnNhap;
        private System.Windows.Forms.DateTimePicker dtpNgayNhap;
        private System.Windows.Forms.ComboBox cbbMaNCC;
        private System.Windows.Forms.PictureBox pbAnh;
    }
}