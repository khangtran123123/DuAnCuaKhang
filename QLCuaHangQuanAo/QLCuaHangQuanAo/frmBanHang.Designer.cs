namespace QLCuaHangQuanAo
{
    partial class frmBanHang
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
            this.gbHoaDon = new System.Windows.Forms.GroupBox();
            this.cbbMaKhach = new System.Windows.Forms.ComboBox();
            this.cbbMaQL = new System.Windows.Forms.ComboBox();
            this.btnReset = new System.Windows.Forms.Button();
            this.btnXoaHD = new System.Windows.Forms.Button();
            this.btnTaoHD = new System.Windows.Forms.Button();
            this.txtMaHD = new System.Windows.Forms.TextBox();
            this.dtpNgayBan = new System.Windows.Forms.DateTimePicker();
            this.txtTongTien = new System.Windows.Forms.TextBox();
            this.lblTongTien = new System.Windows.Forms.Label();
            this.lblNgayBan = new System.Windows.Forms.Label();
            this.lblMaKhach = new System.Windows.Forms.Label();
            this.lblMaQL = new System.Windows.Forms.Label();
            this.lblMaHD = new System.Windows.Forms.Label();
            this.pnThongTin = new System.Windows.Forms.Panel();
            this.gbCTHD = new System.Windows.Forms.GroupBox();
            this.btnBan = new System.Windows.Forms.Button();
            this.btnXoaSP = new System.Windows.Forms.Button();
            this.btnThemSP = new System.Windows.Forms.Button();
            this.txtDonGia = new System.Windows.Forms.TextBox();
            this.lblDonGia = new System.Windows.Forms.Label();
            this.txtThanhTien = new System.Windows.Forms.TextBox();
            this.lblThanhTien = new System.Windows.Forms.Label();
            this.cbbMaSP = new System.Windows.Forms.ComboBox();
            this.cbbMaHD = new System.Windows.Forms.ComboBox();
            this.txtGiamGia = new System.Windows.Forms.TextBox();
            this.txtSoLuong = new System.Windows.Forms.TextBox();
            this.lblGiamGia = new System.Windows.Forms.Label();
            this.lblSL = new System.Windows.Forms.Label();
            this.lblMaSP = new System.Windows.Forms.Label();
            this.label5 = new System.Windows.Forms.Label();
            this.lblTieuDe = new System.Windows.Forms.Label();
            this.pnHienThi = new System.Windows.Forms.Panel();
            this.dgvChiTietHD = new System.Windows.Forms.DataGridView();
            this.dgvHoaDon = new System.Windows.Forms.DataGridView();
            this.gbHoaDon.SuspendLayout();
            this.pnThongTin.SuspendLayout();
            this.gbCTHD.SuspendLayout();
            this.pnHienThi.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.dgvChiTietHD)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.dgvHoaDon)).BeginInit();
            this.SuspendLayout();
            // 
            // gbHoaDon
            // 
            this.gbHoaDon.Controls.Add(this.cbbMaKhach);
            this.gbHoaDon.Controls.Add(this.cbbMaQL);
            this.gbHoaDon.Controls.Add(this.btnReset);
            this.gbHoaDon.Controls.Add(this.btnXoaHD);
            this.gbHoaDon.Controls.Add(this.btnTaoHD);
            this.gbHoaDon.Controls.Add(this.txtMaHD);
            this.gbHoaDon.Controls.Add(this.dtpNgayBan);
            this.gbHoaDon.Controls.Add(this.txtTongTien);
            this.gbHoaDon.Controls.Add(this.lblTongTien);
            this.gbHoaDon.Controls.Add(this.txtGiamGia);
            this.gbHoaDon.Controls.Add(this.lblNgayBan);
            this.gbHoaDon.Controls.Add(this.lblGiamGia);
            this.gbHoaDon.Controls.Add(this.lblMaKhach);
            this.gbHoaDon.Controls.Add(this.lblMaQL);
            this.gbHoaDon.Controls.Add(this.lblMaHD);
            this.gbHoaDon.Font = new System.Drawing.Font("Microsoft Sans Serif", 9.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.gbHoaDon.Location = new System.Drawing.Point(33, 60);
            this.gbHoaDon.Name = "gbHoaDon";
            this.gbHoaDon.Size = new System.Drawing.Size(547, 231);
            this.gbHoaDon.TabIndex = 1;
            this.gbHoaDon.TabStop = false;
            this.gbHoaDon.Text = "Thông Tin Hóa Đơn";
            // 
            // cbbMaKhach
            // 
            this.cbbMaKhach.FormattingEnabled = true;
            this.cbbMaKhach.Location = new System.Drawing.Point(130, 145);
            this.cbbMaKhach.Name = "cbbMaKhach";
            this.cbbMaKhach.Size = new System.Drawing.Size(119, 24);
            this.cbbMaKhach.TabIndex = 19;
            // 
            // cbbMaQL
            // 
            this.cbbMaQL.FormattingEnabled = true;
            this.cbbMaQL.Location = new System.Drawing.Point(129, 89);
            this.cbbMaQL.Name = "cbbMaQL";
            this.cbbMaQL.Size = new System.Drawing.Size(119, 24);
            this.cbbMaQL.TabIndex = 16;
            // 
            // btnReset
            // 
            this.btnReset.Location = new System.Drawing.Point(403, 184);
            this.btnReset.Name = "btnReset";
            this.btnReset.Size = new System.Drawing.Size(116, 41);
            this.btnReset.TabIndex = 18;
            this.btnReset.Text = "Cập Nhật";
            this.btnReset.UseVisualStyleBackColor = true;
            this.btnReset.Click += new System.EventHandler(this.btnReset_Click);
            // 
            // btnXoaHD
            // 
            this.btnXoaHD.Location = new System.Drawing.Point(222, 188);
            this.btnXoaHD.Name = "btnXoaHD";
            this.btnXoaHD.Size = new System.Drawing.Size(116, 41);
            this.btnXoaHD.TabIndex = 17;
            this.btnXoaHD.Text = "Xóa HD";
            this.btnXoaHD.UseVisualStyleBackColor = true;
            this.btnXoaHD.Click += new System.EventHandler(this.btnXoaHD_Click);
            // 
            // btnTaoHD
            // 
            this.btnTaoHD.Location = new System.Drawing.Point(41, 186);
            this.btnTaoHD.Name = "btnTaoHD";
            this.btnTaoHD.Size = new System.Drawing.Size(116, 41);
            this.btnTaoHD.TabIndex = 16;
            this.btnTaoHD.Text = "Tạo HD";
            this.btnTaoHD.UseVisualStyleBackColor = true;
            this.btnTaoHD.Click += new System.EventHandler(this.btnTaoHD_Click);
            // 
            // txtMaHD
            // 
            this.txtMaHD.Location = new System.Drawing.Point(129, 32);
            this.txtMaHD.Name = "txtMaHD";
            this.txtMaHD.Size = new System.Drawing.Size(120, 22);
            this.txtMaHD.TabIndex = 15;
            // 
            // dtpNgayBan
            // 
            this.dtpNgayBan.Format = System.Windows.Forms.DateTimePickerFormat.Short;
            this.dtpNgayBan.Location = new System.Drawing.Point(345, 36);
            this.dtpNgayBan.Name = "dtpNgayBan";
            this.dtpNgayBan.Size = new System.Drawing.Size(174, 22);
            this.dtpNgayBan.TabIndex = 14;
            // 
            // txtTongTien
            // 
            this.txtTongTien.Location = new System.Drawing.Point(345, 145);
            this.txtTongTien.Name = "txtTongTien";
            this.txtTongTien.Size = new System.Drawing.Size(174, 22);
            this.txtTongTien.TabIndex = 10;
            // 
            // lblTongTien
            // 
            this.lblTongTien.AutoSize = true;
            this.lblTongTien.Location = new System.Drawing.Point(260, 148);
            this.lblTongTien.Name = "lblTongTien";
            this.lblTongTien.Size = new System.Drawing.Size(66, 16);
            this.lblTongTien.TabIndex = 4;
            this.lblTongTien.Text = "Tổng tiền:";
            // 
            // lblNgayBan
            // 
            this.lblNgayBan.AutoSize = true;
            this.lblNgayBan.Location = new System.Drawing.Point(260, 36);
            this.lblNgayBan.Name = "lblNgayBan";
            this.lblNgayBan.Size = new System.Drawing.Size(70, 16);
            this.lblNgayBan.TabIndex = 3;
            this.lblNgayBan.Text = "Ngày Bán:";
            // 
            // lblMaKhach
            // 
            this.lblMaKhach.AutoSize = true;
            this.lblMaKhach.Location = new System.Drawing.Point(38, 150);
            this.lblMaKhach.Name = "lblMaKhach";
            this.lblMaKhach.Size = new System.Drawing.Size(69, 16);
            this.lblMaKhach.TabIndex = 2;
            this.lblMaKhach.Text = "Mã Khách:";
            // 
            // lblMaQL
            // 
            this.lblMaQL.AutoSize = true;
            this.lblMaQL.Location = new System.Drawing.Point(38, 89);
            this.lblMaQL.Name = "lblMaQL";
            this.lblMaQL.Size = new System.Drawing.Size(81, 16);
            this.lblMaQL.TabIndex = 1;
            this.lblMaQL.Text = "Mã Quản Lý:";
            // 
            // lblMaHD
            // 
            this.lblMaHD.AutoSize = true;
            this.lblMaHD.Location = new System.Drawing.Point(38, 34);
            this.lblMaHD.Name = "lblMaHD";
            this.lblMaHD.Size = new System.Drawing.Size(85, 16);
            this.lblMaHD.TabIndex = 0;
            this.lblMaHD.Text = "Mã Hóa Đơn:";
            // 
            // pnThongTin
            // 
            this.pnThongTin.Controls.Add(this.gbCTHD);
            this.pnThongTin.Controls.Add(this.lblTieuDe);
            this.pnThongTin.Controls.Add(this.gbHoaDon);
            this.pnThongTin.Dock = System.Windows.Forms.DockStyle.Fill;
            this.pnThongTin.Location = new System.Drawing.Point(0, 0);
            this.pnThongTin.Name = "pnThongTin";
            this.pnThongTin.Size = new System.Drawing.Size(1184, 297);
            this.pnThongTin.TabIndex = 2;
            // 
            // gbCTHD
            // 
            this.gbCTHD.Controls.Add(this.btnBan);
            this.gbCTHD.Controls.Add(this.btnXoaSP);
            this.gbCTHD.Controls.Add(this.btnThemSP);
            this.gbCTHD.Controls.Add(this.txtDonGia);
            this.gbCTHD.Controls.Add(this.lblDonGia);
            this.gbCTHD.Controls.Add(this.txtThanhTien);
            this.gbCTHD.Controls.Add(this.lblThanhTien);
            this.gbCTHD.Controls.Add(this.cbbMaSP);
            this.gbCTHD.Controls.Add(this.cbbMaHD);
            this.gbCTHD.Controls.Add(this.txtSoLuong);
            this.gbCTHD.Controls.Add(this.lblSL);
            this.gbCTHD.Controls.Add(this.lblMaSP);
            this.gbCTHD.Controls.Add(this.label5);
            this.gbCTHD.Font = new System.Drawing.Font("Microsoft Sans Serif", 9.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.gbCTHD.Location = new System.Drawing.Point(599, 60);
            this.gbCTHD.Name = "gbCTHD";
            this.gbCTHD.Size = new System.Drawing.Size(557, 231);
            this.gbCTHD.TabIndex = 15;
            this.gbCTHD.TabStop = false;
            this.gbCTHD.Text = "Chi Tiết Hóa Đơn";
            // 
            // btnBan
            // 
            this.btnBan.Location = new System.Drawing.Point(419, 184);
            this.btnBan.Name = "btnBan";
            this.btnBan.Size = new System.Drawing.Size(116, 41);
            this.btnBan.TabIndex = 22;
            this.btnBan.Text = "Bán";
            this.btnBan.UseVisualStyleBackColor = true;
            this.btnBan.Click += new System.EventHandler(this.btnBan_Click);
            // 
            // btnXoaSP
            // 
            this.btnXoaSP.Location = new System.Drawing.Point(228, 184);
            this.btnXoaSP.Name = "btnXoaSP";
            this.btnXoaSP.Size = new System.Drawing.Size(116, 41);
            this.btnXoaSP.TabIndex = 21;
            this.btnXoaSP.Text = "Xóa SP";
            this.btnXoaSP.UseVisualStyleBackColor = true;
            this.btnXoaSP.Click += new System.EventHandler(this.btnXoaSP_Click);
            // 
            // btnThemSP
            // 
            this.btnThemSP.Location = new System.Drawing.Point(37, 184);
            this.btnThemSP.Name = "btnThemSP";
            this.btnThemSP.Size = new System.Drawing.Size(116, 41);
            this.btnThemSP.TabIndex = 20;
            this.btnThemSP.Text = "Thêm SP";
            this.btnThemSP.UseVisualStyleBackColor = true;
            this.btnThemSP.Click += new System.EventHandler(this.btnThemSP_Click);
            // 
            // txtDonGia
            // 
            this.txtDonGia.Location = new System.Drawing.Point(125, 146);
            this.txtDonGia.Name = "txtDonGia";
            this.txtDonGia.Size = new System.Drawing.Size(170, 22);
            this.txtDonGia.TabIndex = 19;
            // 
            // lblDonGia
            // 
            this.lblDonGia.AutoSize = true;
            this.lblDonGia.Location = new System.Drawing.Point(34, 149);
            this.lblDonGia.Name = "lblDonGia";
            this.lblDonGia.Size = new System.Drawing.Size(58, 16);
            this.lblDonGia.TabIndex = 18;
            this.lblDonGia.Text = "Đơn Giá:";
            // 
            // txtThanhTien
            // 
            this.txtThanhTien.Location = new System.Drawing.Point(415, 83);
            this.txtThanhTien.Name = "txtThanhTien";
            this.txtThanhTien.Size = new System.Drawing.Size(120, 22);
            this.txtThanhTien.TabIndex = 17;
            // 
            // lblThanhTien
            // 
            this.lblThanhTien.AutoSize = true;
            this.lblThanhTien.Location = new System.Drawing.Point(330, 86);
            this.lblThanhTien.Name = "lblThanhTien";
            this.lblThanhTien.Size = new System.Drawing.Size(78, 16);
            this.lblThanhTien.TabIndex = 16;
            this.lblThanhTien.Text = "Thành Tiền:";
            // 
            // cbbMaSP
            // 
            this.cbbMaSP.FormattingEnabled = true;
            this.cbbMaSP.Location = new System.Drawing.Point(125, 83);
            this.cbbMaSP.Name = "cbbMaSP";
            this.cbbMaSP.Size = new System.Drawing.Size(170, 24);
            this.cbbMaSP.TabIndex = 15;
            this.cbbMaSP.SelectedIndexChanged += new System.EventHandler(this.cbbMaSP_SelectedIndexChanged);
            // 
            // cbbMaHD
            // 
            this.cbbMaHD.FormattingEnabled = true;
            this.cbbMaHD.Location = new System.Drawing.Point(125, 30);
            this.cbbMaHD.Name = "cbbMaHD";
            this.cbbMaHD.Size = new System.Drawing.Size(170, 24);
            this.cbbMaHD.TabIndex = 12;
            // 
            // txtGiamGia
            // 
            this.txtGiamGia.Location = new System.Drawing.Point(345, 91);
            this.txtGiamGia.Name = "txtGiamGia";
            this.txtGiamGia.Size = new System.Drawing.Size(174, 22);
            this.txtGiamGia.TabIndex = 10;
            // 
            // txtSoLuong
            // 
            this.txtSoLuong.Location = new System.Drawing.Point(415, 33);
            this.txtSoLuong.Name = "txtSoLuong";
            this.txtSoLuong.Size = new System.Drawing.Size(120, 22);
            this.txtSoLuong.TabIndex = 6;
            this.txtSoLuong.TextChanged += new System.EventHandler(this.txtSoLuong_TextChanged);
            // 
            // lblGiamGia
            // 
            this.lblGiamGia.AutoSize = true;
            this.lblGiamGia.Location = new System.Drawing.Point(260, 94);
            this.lblGiamGia.Name = "lblGiamGia";
            this.lblGiamGia.Size = new System.Drawing.Size(66, 16);
            this.lblGiamGia.TabIndex = 4;
            this.lblGiamGia.Text = "Giảm Giá:";
            // 
            // lblSL
            // 
            this.lblSL.AutoSize = true;
            this.lblSL.Location = new System.Drawing.Point(330, 36);
            this.lblSL.Name = "lblSL";
            this.lblSL.Size = new System.Drawing.Size(67, 16);
            this.lblSL.TabIndex = 2;
            this.lblSL.Text = "Số Lượng:";
            // 
            // lblMaSP
            // 
            this.lblMaSP.AutoSize = true;
            this.lblMaSP.Location = new System.Drawing.Point(34, 91);
            this.lblMaSP.Name = "lblMaSP";
            this.lblMaSP.Size = new System.Drawing.Size(94, 16);
            this.lblMaSP.TabIndex = 1;
            this.lblMaSP.Text = "Mã Sản Phẩm:";
            // 
            // label5
            // 
            this.label5.AutoSize = true;
            this.label5.Location = new System.Drawing.Point(34, 36);
            this.label5.Name = "label5";
            this.label5.Size = new System.Drawing.Size(85, 16);
            this.label5.TabIndex = 0;
            this.label5.Text = "Mã Hóa Đơn:";
            // 
            // lblTieuDe
            // 
            this.lblTieuDe.AutoSize = true;
            this.lblTieuDe.Font = new System.Drawing.Font("Microsoft Sans Serif", 21.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.lblTieuDe.Location = new System.Drawing.Point(530, 18);
            this.lblTieuDe.Name = "lblTieuDe";
            this.lblTieuDe.Size = new System.Drawing.Size(143, 33);
            this.lblTieuDe.TabIndex = 2;
            this.lblTieuDe.Text = "Bán Hàng";
            // 
            // pnHienThi
            // 
            this.pnHienThi.Controls.Add(this.dgvChiTietHD);
            this.pnHienThi.Controls.Add(this.dgvHoaDon);
            this.pnHienThi.Dock = System.Windows.Forms.DockStyle.Bottom;
            this.pnHienThi.Location = new System.Drawing.Point(0, 297);
            this.pnHienThi.Name = "pnHienThi";
            this.pnHienThi.Size = new System.Drawing.Size(1184, 464);
            this.pnHienThi.TabIndex = 3;
            // 
            // dgvChiTietHD
            // 
            this.dgvChiTietHD.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            this.dgvChiTietHD.Location = new System.Drawing.Point(599, 26);
            this.dgvChiTietHD.Name = "dgvChiTietHD";
            this.dgvChiTietHD.Size = new System.Drawing.Size(557, 395);
            this.dgvChiTietHD.TabIndex = 1;
            // 
            // dgvHoaDon
            // 
            this.dgvHoaDon.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            this.dgvHoaDon.Location = new System.Drawing.Point(26, 26);
            this.dgvHoaDon.Name = "dgvHoaDon";
            this.dgvHoaDon.Size = new System.Drawing.Size(554, 395);
            this.dgvHoaDon.TabIndex = 0;
            this.dgvHoaDon.CellClick += new System.Windows.Forms.DataGridViewCellEventHandler(this.dgvHoaDon_CellClick);
            // 
            // frmBanHang
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(1184, 761);
            this.Controls.Add(this.pnThongTin);
            this.Controls.Add(this.pnHienThi);
            this.MaximizeBox = false;
            this.MaximumSize = new System.Drawing.Size(1200, 800);
            this.MinimizeBox = false;
            this.MinimumSize = new System.Drawing.Size(1200, 800);
            this.Name = "frmBanHang";
            this.Text = "frmBanHang";
            this.Load += new System.EventHandler(this.frmBanHang_Load);
            this.gbHoaDon.ResumeLayout(false);
            this.gbHoaDon.PerformLayout();
            this.pnThongTin.ResumeLayout(false);
            this.pnThongTin.PerformLayout();
            this.gbCTHD.ResumeLayout(false);
            this.gbCTHD.PerformLayout();
            this.pnHienThi.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.dgvChiTietHD)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.dgvHoaDon)).EndInit();
            this.ResumeLayout(false);

        }

        #endregion

        private System.Windows.Forms.GroupBox gbHoaDon;
        private System.Windows.Forms.DateTimePicker dtpNgayBan;
        private System.Windows.Forms.TextBox txtTongTien;
        private System.Windows.Forms.Label lblTongTien;
        private System.Windows.Forms.Label lblNgayBan;
        private System.Windows.Forms.Label lblMaKhach;
        private System.Windows.Forms.Label lblMaQL;
        private System.Windows.Forms.Label lblMaHD;
        private System.Windows.Forms.Panel pnThongTin;
        private System.Windows.Forms.GroupBox gbCTHD;
        private System.Windows.Forms.ComboBox cbbMaHD;
        private System.Windows.Forms.TextBox txtGiamGia;
        private System.Windows.Forms.TextBox txtSoLuong;
        private System.Windows.Forms.Label lblGiamGia;
        private System.Windows.Forms.Label lblSL;
        private System.Windows.Forms.Label lblMaSP;
        private System.Windows.Forms.Label label5;
        private System.Windows.Forms.Label lblTieuDe;
        private System.Windows.Forms.Panel pnHienThi;
        private System.Windows.Forms.DataGridView dgvChiTietHD;
        private System.Windows.Forms.DataGridView dgvHoaDon;
        private System.Windows.Forms.TextBox txtMaHD;
        private System.Windows.Forms.ComboBox cbbMaSP;
        private System.Windows.Forms.TextBox txtThanhTien;
        private System.Windows.Forms.Label lblThanhTien;
        private System.Windows.Forms.TextBox txtDonGia;
        private System.Windows.Forms.Label lblDonGia;
        private System.Windows.Forms.Button btnTaoHD;
        private System.Windows.Forms.Button btnXoaHD;
        private System.Windows.Forms.Button btnBan;
        private System.Windows.Forms.Button btnXoaSP;
        private System.Windows.Forms.Button btnThemSP;
        private System.Windows.Forms.Button btnReset;
        private System.Windows.Forms.ComboBox cbbMaQL;
        private System.Windows.Forms.ComboBox cbbMaKhach;
    }
}