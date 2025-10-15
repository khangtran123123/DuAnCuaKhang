namespace QLCuaHangQuanAo
{
    partial class frmKhach
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
            this.btnThem = new System.Windows.Forms.Button();
            this.btnThoat = new System.Windows.Forms.Button();
            this.btnXoa = new System.Windows.Forms.Button();
            this.btnSua = new System.Windows.Forms.Button();
            this.txtSDTKhach = new System.Windows.Forms.TextBox();
            this.txtTenKhach = new System.Windows.Forms.TextBox();
            this.pnHienThi = new System.Windows.Forms.Panel();
            this.dgvKhach = new System.Windows.Forms.DataGridView();
            this.lblTieuDe = new System.Windows.Forms.Label();
            this.txtMaKhach = new System.Windows.Forms.TextBox();
            this.lblSDTKhach = new System.Windows.Forms.Label();
            this.lblGioiTinh = new System.Windows.Forms.Label();
            this.lblMaKhach = new System.Windows.Forms.Label();
            this.lblTenKhach = new System.Windows.Forms.Label();
            this.pnNhapTT = new System.Windows.Forms.Panel();
            this.cbbGioiTinhKhach = new System.Windows.Forms.ComboBox();
            this.pbAnh = new System.Windows.Forms.PictureBox();
            this.pnHienThi.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.dgvKhach)).BeginInit();
            this.pnNhapTT.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.pbAnh)).BeginInit();
            this.SuspendLayout();
            // 
            // btnThem
            // 
            this.btnThem.Font = new System.Drawing.Font("Microsoft Sans Serif", 9.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.btnThem.Location = new System.Drawing.Point(34, 584);
            this.btnThem.Name = "btnThem";
            this.btnThem.Size = new System.Drawing.Size(102, 50);
            this.btnThem.TabIndex = 20;
            this.btnThem.Text = "Thêm";
            this.btnThem.UseVisualStyleBackColor = true;
            this.btnThem.Click += new System.EventHandler(this.btnThem_Click);
            // 
            // btnThoat
            // 
            this.btnThoat.Font = new System.Drawing.Font("Microsoft Sans Serif", 9.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.btnThoat.Location = new System.Drawing.Point(142, 640);
            this.btnThoat.Name = "btnThoat";
            this.btnThoat.Size = new System.Drawing.Size(102, 50);
            this.btnThoat.TabIndex = 14;
            this.btnThoat.Text = "Thoát";
            this.btnThoat.UseVisualStyleBackColor = true;
            this.btnThoat.Click += new System.EventHandler(this.btnThoat_Click);
            // 
            // btnXoa
            // 
            this.btnXoa.Font = new System.Drawing.Font("Microsoft Sans Serif", 9.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.btnXoa.Location = new System.Drawing.Point(142, 584);
            this.btnXoa.Name = "btnXoa";
            this.btnXoa.Size = new System.Drawing.Size(104, 50);
            this.btnXoa.TabIndex = 13;
            this.btnXoa.Text = "Xóa";
            this.btnXoa.UseVisualStyleBackColor = true;
            this.btnXoa.Click += new System.EventHandler(this.btnXoa_Click);
            // 
            // btnSua
            // 
            this.btnSua.Font = new System.Drawing.Font("Microsoft Sans Serif", 9.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.btnSua.Location = new System.Drawing.Point(34, 640);
            this.btnSua.Name = "btnSua";
            this.btnSua.Size = new System.Drawing.Size(102, 50);
            this.btnSua.TabIndex = 12;
            this.btnSua.Text = "Sửa";
            this.btnSua.UseVisualStyleBackColor = true;
            this.btnSua.Click += new System.EventHandler(this.btnSua_Click);
            // 
            // txtSDTKhach
            // 
            this.txtSDTKhach.Location = new System.Drawing.Point(34, 532);
            this.txtSDTKhach.Name = "txtSDTKhach";
            this.txtSDTKhach.Size = new System.Drawing.Size(212, 20);
            this.txtSDTKhach.TabIndex = 9;
            // 
            // txtTenKhach
            // 
            this.txtTenKhach.Location = new System.Drawing.Point(34, 355);
            this.txtTenKhach.Name = "txtTenKhach";
            this.txtTenKhach.Size = new System.Drawing.Size(212, 20);
            this.txtTenKhach.TabIndex = 7;
            // 
            // pnHienThi
            // 
            this.pnHienThi.Controls.Add(this.dgvKhach);
            this.pnHienThi.Controls.Add(this.lblTieuDe);
            this.pnHienThi.Dock = System.Windows.Forms.DockStyle.Fill;
            this.pnHienThi.Location = new System.Drawing.Point(0, 0);
            this.pnHienThi.Name = "pnHienThi";
            this.pnHienThi.Size = new System.Drawing.Size(902, 761);
            this.pnHienThi.TabIndex = 3;
            // 
            // dgvKhach
            // 
            this.dgvKhach.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            this.dgvKhach.Location = new System.Drawing.Point(32, 115);
            this.dgvKhach.Name = "dgvKhach";
            this.dgvKhach.Size = new System.Drawing.Size(832, 612);
            this.dgvKhach.TabIndex = 1;
            this.dgvKhach.CellClick += new System.Windows.Forms.DataGridViewCellEventHandler(this.dgvKhach_CellClick);
            // 
            // lblTieuDe
            // 
            this.lblTieuDe.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(255)))), ((int)(((byte)(255)))), ((int)(((byte)(192)))));
            this.lblTieuDe.Font = new System.Drawing.Font("Microsoft Sans Serif", 21.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.lblTieuDe.Location = new System.Drawing.Point(0, 0);
            this.lblTieuDe.Name = "lblTieuDe";
            this.lblTieuDe.Size = new System.Drawing.Size(920, 77);
            this.lblTieuDe.TabIndex = 0;
            this.lblTieuDe.Text = "Thông Tin Khách Hàng";
            this.lblTieuDe.TextAlign = System.Drawing.ContentAlignment.MiddleCenter;
            // 
            // txtMaKhach
            // 
            this.txtMaKhach.Location = new System.Drawing.Point(34, 267);
            this.txtMaKhach.Name = "txtMaKhach";
            this.txtMaKhach.Size = new System.Drawing.Size(212, 20);
            this.txtMaKhach.TabIndex = 6;
            // 
            // lblSDTKhach
            // 
            this.lblSDTKhach.AutoSize = true;
            this.lblSDTKhach.Font = new System.Drawing.Font("Microsoft Sans Serif", 9.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.lblSDTKhach.Location = new System.Drawing.Point(31, 490);
            this.lblSDTKhach.Name = "lblSDTKhach";
            this.lblSDTKhach.Size = new System.Drawing.Size(95, 16);
            this.lblSDTKhach.TabIndex = 3;
            this.lblSDTKhach.Text = "Số Điện Thoại:";
            // 
            // lblGioiTinh
            // 
            this.lblGioiTinh.AutoSize = true;
            this.lblGioiTinh.Font = new System.Drawing.Font("Microsoft Sans Serif", 9.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.lblGioiTinh.Location = new System.Drawing.Point(31, 401);
            this.lblGioiTinh.Name = "lblGioiTinh";
            this.lblGioiTinh.Size = new System.Drawing.Size(139, 16);
            this.lblGioiTinh.TabIndex = 2;
            this.lblGioiTinh.Text = "Giới Tính Khách Hàng:";
            // 
            // lblMaKhach
            // 
            this.lblMaKhach.AutoSize = true;
            this.lblMaKhach.Font = new System.Drawing.Font("Microsoft Sans Serif", 9.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.lblMaKhach.Location = new System.Drawing.Point(33, 225);
            this.lblMaKhach.Name = "lblMaKhach";
            this.lblMaKhach.Size = new System.Drawing.Size(105, 16);
            this.lblMaKhach.TabIndex = 0;
            this.lblMaKhach.Text = "Mã Khách Hàng:";
            // 
            // lblTenKhach
            // 
            this.lblTenKhach.AutoSize = true;
            this.lblTenKhach.Font = new System.Drawing.Font("Microsoft Sans Serif", 9.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.lblTenKhach.Location = new System.Drawing.Point(31, 313);
            this.lblTenKhach.Name = "lblTenKhach";
            this.lblTenKhach.Size = new System.Drawing.Size(110, 16);
            this.lblTenKhach.TabIndex = 1;
            this.lblTenKhach.Text = "Tên Khách Hàng:";
            // 
            // pnNhapTT
            // 
            this.pnNhapTT.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(192)))), ((int)(((byte)(255)))), ((int)(((byte)(255)))));
            this.pnNhapTT.Controls.Add(this.pbAnh);
            this.pnNhapTT.Controls.Add(this.cbbGioiTinhKhach);
            this.pnNhapTT.Controls.Add(this.btnThem);
            this.pnNhapTT.Controls.Add(this.btnThoat);
            this.pnNhapTT.Controls.Add(this.btnXoa);
            this.pnNhapTT.Controls.Add(this.btnSua);
            this.pnNhapTT.Controls.Add(this.txtSDTKhach);
            this.pnNhapTT.Controls.Add(this.txtTenKhach);
            this.pnNhapTT.Controls.Add(this.txtMaKhach);
            this.pnNhapTT.Controls.Add(this.lblSDTKhach);
            this.pnNhapTT.Controls.Add(this.lblGioiTinh);
            this.pnNhapTT.Controls.Add(this.lblTenKhach);
            this.pnNhapTT.Controls.Add(this.lblMaKhach);
            this.pnNhapTT.Dock = System.Windows.Forms.DockStyle.Right;
            this.pnNhapTT.Location = new System.Drawing.Point(902, 0);
            this.pnNhapTT.Name = "pnNhapTT";
            this.pnNhapTT.Size = new System.Drawing.Size(282, 761);
            this.pnNhapTT.TabIndex = 4;
            // 
            // cbbGioiTinhKhach
            // 
            this.cbbGioiTinhKhach.FormattingEnabled = true;
            this.cbbGioiTinhKhach.Items.AddRange(new object[] {
            "Nam",
            "Nữ"});
            this.cbbGioiTinhKhach.Location = new System.Drawing.Point(34, 443);
            this.cbbGioiTinhKhach.Name = "cbbGioiTinhKhach";
            this.cbbGioiTinhKhach.Size = new System.Drawing.Size(209, 21);
            this.cbbGioiTinhKhach.TabIndex = 21;
            // 
            // pbAnh
            // 
            this.pbAnh.Image = global::QLCuaHangQuanAo.Properties.Resources.guest__2_;
            this.pbAnh.Location = new System.Drawing.Point(47, 14);
            this.pbAnh.Name = "pbAnh";
            this.pbAnh.Size = new System.Drawing.Size(223, 191);
            this.pbAnh.TabIndex = 22;
            this.pbAnh.TabStop = false;
            // 
            // frmKhach
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(1184, 761);
            this.Controls.Add(this.pnHienThi);
            this.Controls.Add(this.pnNhapTT);
            this.MaximizeBox = false;
            this.MaximumSize = new System.Drawing.Size(1200, 800);
            this.MinimizeBox = false;
            this.MinimumSize = new System.Drawing.Size(1200, 800);
            this.Name = "frmKhach";
            this.Text = "frmKhach";
            this.Load += new System.EventHandler(this.frmKhach_Load);
            this.pnHienThi.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.dgvKhach)).EndInit();
            this.pnNhapTT.ResumeLayout(false);
            this.pnNhapTT.PerformLayout();
            ((System.ComponentModel.ISupportInitialize)(this.pbAnh)).EndInit();
            this.ResumeLayout(false);

        }

        #endregion

        private System.Windows.Forms.Button btnThem;
        private System.Windows.Forms.Button btnThoat;
        private System.Windows.Forms.Button btnXoa;
        private System.Windows.Forms.Button btnSua;
        private System.Windows.Forms.TextBox txtSDTKhach;
        private System.Windows.Forms.TextBox txtTenKhach;
        private System.Windows.Forms.Panel pnHienThi;
        private System.Windows.Forms.DataGridView dgvKhach;
        private System.Windows.Forms.Label lblTieuDe;
        private System.Windows.Forms.TextBox txtMaKhach;
        private System.Windows.Forms.Label lblSDTKhach;
        private System.Windows.Forms.Label lblGioiTinh;
        private System.Windows.Forms.Label lblMaKhach;
        private System.Windows.Forms.Label lblTenKhach;
        private System.Windows.Forms.Panel pnNhapTT;
        private System.Windows.Forms.ComboBox cbbGioiTinhKhach;
        private System.Windows.Forms.PictureBox pbAnh;
    }
}