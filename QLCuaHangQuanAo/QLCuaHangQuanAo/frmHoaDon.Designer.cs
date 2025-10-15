namespace QLCuaHangQuanAo
{
    partial class frmHoaDon
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
            this.pnThongTinHD = new System.Windows.Forms.Panel();
            this.lblTieuDe = new System.Windows.Forms.Label();
            this.gbHoaDon = new System.Windows.Forms.GroupBox();
            this.btnXoaHD = new System.Windows.Forms.Button();
            this.txtMaHD = new System.Windows.Forms.TextBox();
            this.dtpNgayNhap = new System.Windows.Forms.DateTimePicker();
            this.btnThoat = new System.Windows.Forms.Button();
            this.txtTongTien = new System.Windows.Forms.TextBox();
            this.txtMaQL = new System.Windows.Forms.TextBox();
            this.txtMaKhach = new System.Windows.Forms.TextBox();
            this.lblTongTien = new System.Windows.Forms.Label();
            this.lblNgayNhap = new System.Windows.Forms.Label();
            this.lblMaKhach = new System.Windows.Forms.Label();
            this.lblMaQL = new System.Windows.Forms.Label();
            this.lblMaHD = new System.Windows.Forms.Label();
            this.pnHienThi = new System.Windows.Forms.Panel();
            this.gbHienThiCTHD = new System.Windows.Forms.GroupBox();
            this.dgvCTHD = new System.Windows.Forms.DataGridView();
            this.gbHienThiHD = new System.Windows.Forms.GroupBox();
            this.dgvHoaDon = new System.Windows.Forms.DataGridView();
            this.txtGiamGia = new System.Windows.Forms.TextBox();
            this.lblGiamGia = new System.Windows.Forms.Label();
            this.pnThongTinHD.SuspendLayout();
            this.gbHoaDon.SuspendLayout();
            this.pnHienThi.SuspendLayout();
            this.gbHienThiCTHD.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.dgvCTHD)).BeginInit();
            this.gbHienThiHD.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.dgvHoaDon)).BeginInit();
            this.SuspendLayout();
            // 
            // pnThongTinHD
            // 
            this.pnThongTinHD.Controls.Add(this.lblTieuDe);
            this.pnThongTinHD.Controls.Add(this.gbHoaDon);
            this.pnThongTinHD.Dock = System.Windows.Forms.DockStyle.Fill;
            this.pnThongTinHD.Location = new System.Drawing.Point(0, 0);
            this.pnThongTinHD.Name = "pnThongTinHD";
            this.pnThongTinHD.Size = new System.Drawing.Size(1184, 761);
            this.pnThongTinHD.TabIndex = 0;
            // 
            // lblTieuDe
            // 
            this.lblTieuDe.AutoSize = true;
            this.lblTieuDe.Font = new System.Drawing.Font("Microsoft Sans Serif", 21.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.lblTieuDe.Location = new System.Drawing.Point(521, 30);
            this.lblTieuDe.Name = "lblTieuDe";
            this.lblTieuDe.Size = new System.Drawing.Size(129, 33);
            this.lblTieuDe.TabIndex = 2;
            this.lblTieuDe.Text = "Hóa Đơn";
            // 
            // gbHoaDon
            // 
            this.gbHoaDon.Controls.Add(this.txtGiamGia);
            this.gbHoaDon.Controls.Add(this.lblGiamGia);
            this.gbHoaDon.Controls.Add(this.btnXoaHD);
            this.gbHoaDon.Controls.Add(this.txtMaHD);
            this.gbHoaDon.Controls.Add(this.dtpNgayNhap);
            this.gbHoaDon.Controls.Add(this.btnThoat);
            this.gbHoaDon.Controls.Add(this.txtTongTien);
            this.gbHoaDon.Controls.Add(this.txtMaQL);
            this.gbHoaDon.Controls.Add(this.txtMaKhach);
            this.gbHoaDon.Controls.Add(this.lblTongTien);
            this.gbHoaDon.Controls.Add(this.lblNgayNhap);
            this.gbHoaDon.Controls.Add(this.lblMaKhach);
            this.gbHoaDon.Controls.Add(this.lblMaQL);
            this.gbHoaDon.Controls.Add(this.lblMaHD);
            this.gbHoaDon.Font = new System.Drawing.Font("Microsoft Sans Serif", 9.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.gbHoaDon.Location = new System.Drawing.Point(26, 79);
            this.gbHoaDon.Name = "gbHoaDon";
            this.gbHoaDon.Size = new System.Drawing.Size(1129, 190);
            this.gbHoaDon.TabIndex = 1;
            this.gbHoaDon.TabStop = false;
            this.gbHoaDon.Text = "Thông Tin Hóa Đơn";
            // 
            // btnXoaHD
            // 
            this.btnXoaHD.Font = new System.Drawing.Font("Microsoft Sans Serif", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.btnXoaHD.Location = new System.Drawing.Point(985, 33);
            this.btnXoaHD.Name = "btnXoaHD";
            this.btnXoaHD.Size = new System.Drawing.Size(117, 50);
            this.btnXoaHD.TabIndex = 15;
            this.btnXoaHD.Text = "Xóa";
            this.btnXoaHD.UseVisualStyleBackColor = true;
            this.btnXoaHD.Click += new System.EventHandler(this.btnXoaHD_Click);
            // 
            // txtMaHD
            // 
            this.txtMaHD.Location = new System.Drawing.Point(169, 33);
            this.txtMaHD.Name = "txtMaHD";
            this.txtMaHD.Size = new System.Drawing.Size(322, 22);
            this.txtMaHD.TabIndex = 3;
            this.txtMaHD.TextChanged += new System.EventHandler(this.txtMaHD_TextChanged);
            // 
            // dtpNgayNhap
            // 
            this.dtpNgayNhap.Format = System.Windows.Forms.DateTimePickerFormat.Short;
            this.dtpNgayNhap.Location = new System.Drawing.Point(628, 33);
            this.dtpNgayNhap.Name = "dtpNgayNhap";
            this.dtpNgayNhap.Size = new System.Drawing.Size(310, 22);
            this.dtpNgayNhap.TabIndex = 14;
            // 
            // btnThoat
            // 
            this.btnThoat.Font = new System.Drawing.Font("Microsoft Sans Serif", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.btnThoat.Location = new System.Drawing.Point(985, 121);
            this.btnThoat.Name = "btnThoat";
            this.btnThoat.Size = new System.Drawing.Size(117, 50);
            this.btnThoat.TabIndex = 13;
            this.btnThoat.Text = "Thoát";
            this.btnThoat.UseVisualStyleBackColor = true;
            this.btnThoat.Click += new System.EventHandler(this.btnThoat_Click);
            // 
            // txtTongTien
            // 
            this.txtTongTien.Location = new System.Drawing.Point(628, 146);
            this.txtTongTien.Name = "txtTongTien";
            this.txtTongTien.Size = new System.Drawing.Size(310, 22);
            this.txtTongTien.TabIndex = 10;
            // 
            // txtMaQL
            // 
            this.txtMaQL.Location = new System.Drawing.Point(169, 89);
            this.txtMaQL.Name = "txtMaQL";
            this.txtMaQL.Size = new System.Drawing.Size(322, 22);
            this.txtMaQL.TabIndex = 7;
            // 
            // txtMaKhach
            // 
            this.txtMaKhach.Location = new System.Drawing.Point(169, 149);
            this.txtMaKhach.Name = "txtMaKhach";
            this.txtMaKhach.Size = new System.Drawing.Size(322, 22);
            this.txtMaKhach.TabIndex = 6;
            // 
            // lblTongTien
            // 
            this.lblTongTien.AutoSize = true;
            this.lblTongTien.Location = new System.Drawing.Point(543, 149);
            this.lblTongTien.Name = "lblTongTien";
            this.lblTongTien.Size = new System.Drawing.Size(66, 16);
            this.lblTongTien.TabIndex = 4;
            this.lblTongTien.Text = "Tổng tiền:";
            // 
            // lblNgayNhap
            // 
            this.lblNgayNhap.AutoSize = true;
            this.lblNgayNhap.Location = new System.Drawing.Point(543, 33);
            this.lblNgayNhap.Name = "lblNgayNhap";
            this.lblNgayNhap.Size = new System.Drawing.Size(79, 16);
            this.lblNgayNhap.TabIndex = 3;
            this.lblNgayNhap.Text = "Ngày Nhập:";
            // 
            // lblMaKhach
            // 
            this.lblMaKhach.AutoSize = true;
            this.lblMaKhach.Location = new System.Drawing.Point(34, 152);
            this.lblMaKhach.Name = "lblMaKhach";
            this.lblMaKhach.Size = new System.Drawing.Size(69, 16);
            this.lblMaKhach.TabIndex = 2;
            this.lblMaKhach.Text = "Mã Khách:";
            // 
            // lblMaQL
            // 
            this.lblMaQL.AutoSize = true;
            this.lblMaQL.Location = new System.Drawing.Point(34, 91);
            this.lblMaQL.Name = "lblMaQL";
            this.lblMaQL.Size = new System.Drawing.Size(94, 16);
            this.lblMaQL.TabIndex = 1;
            this.lblMaQL.Text = "Mã Nhân Viên:";
            // 
            // lblMaHD
            // 
            this.lblMaHD.AutoSize = true;
            this.lblMaHD.Location = new System.Drawing.Point(34, 36);
            this.lblMaHD.Name = "lblMaHD";
            this.lblMaHD.Size = new System.Drawing.Size(85, 16);
            this.lblMaHD.TabIndex = 0;
            this.lblMaHD.Text = "Mã Hóa Đơn:";
            // 
            // pnHienThi
            // 
            this.pnHienThi.Controls.Add(this.gbHienThiCTHD);
            this.pnHienThi.Controls.Add(this.gbHienThiHD);
            this.pnHienThi.Dock = System.Windows.Forms.DockStyle.Bottom;
            this.pnHienThi.Location = new System.Drawing.Point(0, 275);
            this.pnHienThi.Name = "pnHienThi";
            this.pnHienThi.Size = new System.Drawing.Size(1184, 486);
            this.pnHienThi.TabIndex = 1;
            // 
            // gbHienThiCTHD
            // 
            this.gbHienThiCTHD.Controls.Add(this.dgvCTHD);
            this.gbHienThiCTHD.Location = new System.Drawing.Point(26, 227);
            this.gbHienThiCTHD.Name = "gbHienThiCTHD";
            this.gbHienThiCTHD.Size = new System.Drawing.Size(1129, 205);
            this.gbHienThiCTHD.TabIndex = 2;
            this.gbHienThiCTHD.TabStop = false;
            this.gbHienThiCTHD.Text = "Chi Tiết Hóa Đơn";
            // 
            // dgvCTHD
            // 
            this.dgvCTHD.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            this.dgvCTHD.Location = new System.Drawing.Point(8, 33);
            this.dgvCTHD.Name = "dgvCTHD";
            this.dgvCTHD.Size = new System.Drawing.Size(1107, 154);
            this.dgvCTHD.TabIndex = 0;
            // 
            // gbHienThiHD
            // 
            this.gbHienThiHD.Controls.Add(this.dgvHoaDon);
            this.gbHienThiHD.Location = new System.Drawing.Point(26, 16);
            this.gbHienThiHD.Name = "gbHienThiHD";
            this.gbHienThiHD.Size = new System.Drawing.Size(1129, 205);
            this.gbHienThiHD.TabIndex = 1;
            this.gbHienThiHD.TabStop = false;
            this.gbHienThiHD.Text = "Hóa Đơn";
            // 
            // dgvHoaDon
            // 
            this.dgvHoaDon.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            this.dgvHoaDon.Location = new System.Drawing.Point(8, 33);
            this.dgvHoaDon.Name = "dgvHoaDon";
            this.dgvHoaDon.Size = new System.Drawing.Size(1107, 162);
            this.dgvHoaDon.TabIndex = 0;
            this.dgvHoaDon.CellClick += new System.Windows.Forms.DataGridViewCellEventHandler(this.dgvHoaDon_CellClick);
            // 
            // txtGiamGia
            // 
            this.txtGiamGia.Location = new System.Drawing.Point(628, 89);
            this.txtGiamGia.Name = "txtGiamGia";
            this.txtGiamGia.Size = new System.Drawing.Size(310, 22);
            this.txtGiamGia.TabIndex = 17;
            // 
            // lblGiamGia
            // 
            this.lblGiamGia.AutoSize = true;
            this.lblGiamGia.Location = new System.Drawing.Point(543, 92);
            this.lblGiamGia.Name = "lblGiamGia";
            this.lblGiamGia.Size = new System.Drawing.Size(64, 16);
            this.lblGiamGia.TabIndex = 16;
            this.lblGiamGia.Text = "Giảm giá:";
            // 
            // frmHoaDon
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(1184, 761);
            this.Controls.Add(this.pnHienThi);
            this.Controls.Add(this.pnThongTinHD);
            this.MaximizeBox = false;
            this.MaximumSize = new System.Drawing.Size(1200, 800);
            this.MinimizeBox = false;
            this.MinimumSize = new System.Drawing.Size(1200, 800);
            this.Name = "frmHoaDon";
            this.Text = "frmNhanVien";
            this.Load += new System.EventHandler(this.frmHoaDon_Load);
            this.pnThongTinHD.ResumeLayout(false);
            this.pnThongTinHD.PerformLayout();
            this.gbHoaDon.ResumeLayout(false);
            this.gbHoaDon.PerformLayout();
            this.pnHienThi.ResumeLayout(false);
            this.gbHienThiCTHD.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.dgvCTHD)).EndInit();
            this.gbHienThiHD.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.dgvHoaDon)).EndInit();
            this.ResumeLayout(false);

        }

        #endregion

        private System.Windows.Forms.Panel pnThongTinHD;
        private System.Windows.Forms.Panel pnHienThi;
        private System.Windows.Forms.Label lblTieuDe;
        private System.Windows.Forms.GroupBox gbHoaDon;
        private System.Windows.Forms.DataGridView dgvHoaDon;
        private System.Windows.Forms.Label lblTongTien;
        private System.Windows.Forms.Label lblNgayNhap;
        private System.Windows.Forms.Label lblMaKhach;
        private System.Windows.Forms.Label lblMaQL;
        private System.Windows.Forms.Label lblMaHD;
        private System.Windows.Forms.TextBox txtTongTien;
        private System.Windows.Forms.TextBox txtMaQL;
        private System.Windows.Forms.TextBox txtMaKhach;
        private System.Windows.Forms.DateTimePicker dtpNgayNhap;
        private System.Windows.Forms.Button btnThoat;
        private System.Windows.Forms.GroupBox gbHienThiHD;
        private System.Windows.Forms.GroupBox gbHienThiCTHD;
        private System.Windows.Forms.DataGridView dgvCTHD;
        private System.Windows.Forms.TextBox txtMaHD;
        private System.Windows.Forms.Button btnXoaHD;
        private System.Windows.Forms.TextBox txtGiamGia;
        private System.Windows.Forms.Label lblGiamGia;
    }
}