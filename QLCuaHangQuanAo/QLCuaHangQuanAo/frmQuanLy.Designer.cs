namespace QLCuaHangQuanAo
{
    partial class frmQuanLy
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
            this.dgvQuanLy = new System.Windows.Forms.DataGridView();
            this.btnXoa = new System.Windows.Forms.Button();
            this.btnThem = new System.Windows.Forms.Button();
            this.txtGmail = new System.Windows.Forms.TextBox();
            this.txtMatKhauQL = new System.Windows.Forms.TextBox();
            this.txtSDTQL = new System.Windows.Forms.TextBox();
            this.txtTenQL = new System.Windows.Forms.TextBox();
            this.txtMaQL = new System.Windows.Forms.TextBox();
            this.lblGmail = new System.Windows.Forms.Label();
            this.btnThoat = new System.Windows.Forms.Button();
            this.btnSua = new System.Windows.Forms.Button();
            this.gbTXS = new System.Windows.Forms.GroupBox();
            this.lblMatKhau = new System.Windows.Forms.Label();
            this.lblSDT = new System.Windows.Forms.Label();
            this.lblGioiTinhNV = new System.Windows.Forms.Label();
            this.lblMaNV = new System.Windows.Forms.Label();
            this.pnHienThi = new System.Windows.Forms.Panel();
            this.lblTieuDe = new System.Windows.Forms.Label();
            this.gbTTQL = new System.Windows.Forms.GroupBox();
            this.cbbGioiTinhQL = new System.Windows.Forms.ComboBox();
            this.lblTenNV = new System.Windows.Forms.Label();
            this.pnThongTinQL = new System.Windows.Forms.Panel();
            ((System.ComponentModel.ISupportInitialize)(this.dgvQuanLy)).BeginInit();
            this.gbTXS.SuspendLayout();
            this.pnHienThi.SuspendLayout();
            this.gbTTQL.SuspendLayout();
            this.pnThongTinQL.SuspendLayout();
            this.SuspendLayout();
            // 
            // dgvQuanLy
            // 
            this.dgvQuanLy.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            this.dgvQuanLy.Location = new System.Drawing.Point(26, 26);
            this.dgvQuanLy.Name = "dgvQuanLy";
            this.dgvQuanLy.Size = new System.Drawing.Size(1129, 344);
            this.dgvQuanLy.TabIndex = 0;
            this.dgvQuanLy.CellClick += new System.Windows.Forms.DataGridViewCellEventHandler(this.dgvQuanLy_CellClick);
            // 
            // btnXoa
            // 
            this.btnXoa.Location = new System.Drawing.Point(40, 130);
            this.btnXoa.Name = "btnXoa";
            this.btnXoa.Size = new System.Drawing.Size(94, 44);
            this.btnXoa.TabIndex = 1;
            this.btnXoa.Text = "Xóa";
            this.btnXoa.UseVisualStyleBackColor = true;
            this.btnXoa.Click += new System.EventHandler(this.btnXoa_Click);
            // 
            // btnThem
            // 
            this.btnThem.Location = new System.Drawing.Point(40, 20);
            this.btnThem.Name = "btnThem";
            this.btnThem.Size = new System.Drawing.Size(94, 44);
            this.btnThem.TabIndex = 0;
            this.btnThem.Text = "Thêm";
            this.btnThem.UseVisualStyleBackColor = true;
            this.btnThem.Click += new System.EventHandler(this.btnThem_Click);
            // 
            // txtGmail
            // 
            this.txtGmail.Location = new System.Drawing.Point(591, 167);
            this.txtGmail.Name = "txtGmail";
            this.txtGmail.Size = new System.Drawing.Size(322, 22);
            this.txtGmail.TabIndex = 11;
            // 
            // txtMatKhauQL
            // 
            this.txtMatKhauQL.Location = new System.Drawing.Point(591, 107);
            this.txtMatKhauQL.Name = "txtMatKhauQL";
            this.txtMatKhauQL.Size = new System.Drawing.Size(322, 22);
            this.txtMatKhauQL.TabIndex = 10;
            // 
            // txtSDTQL
            // 
            this.txtSDTQL.Location = new System.Drawing.Point(591, 48);
            this.txtSDTQL.Name = "txtSDTQL";
            this.txtSDTQL.Size = new System.Drawing.Size(322, 22);
            this.txtSDTQL.TabIndex = 9;
            // 
            // txtTenQL
            // 
            this.txtTenQL.Location = new System.Drawing.Point(176, 107);
            this.txtTenQL.Name = "txtTenQL";
            this.txtTenQL.Size = new System.Drawing.Size(322, 22);
            this.txtTenQL.TabIndex = 7;
            // 
            // txtMaQL
            // 
            this.txtMaQL.Location = new System.Drawing.Point(176, 48);
            this.txtMaQL.Name = "txtMaQL";
            this.txtMaQL.Size = new System.Drawing.Size(322, 22);
            this.txtMaQL.TabIndex = 6;
            // 
            // lblGmail
            // 
            this.lblGmail.AutoSize = true;
            this.lblGmail.Location = new System.Drawing.Point(518, 170);
            this.lblGmail.Name = "lblGmail";
            this.lblGmail.Size = new System.Drawing.Size(45, 16);
            this.lblGmail.TabIndex = 5;
            this.lblGmail.Text = "Gmail:";
            // 
            // btnThoat
            // 
            this.btnThoat.Location = new System.Drawing.Point(40, 185);
            this.btnThoat.Name = "btnThoat";
            this.btnThoat.Size = new System.Drawing.Size(94, 44);
            this.btnThoat.TabIndex = 3;
            this.btnThoat.Text = "Thoát";
            this.btnThoat.UseVisualStyleBackColor = true;
            this.btnThoat.Click += new System.EventHandler(this.btnThoat_Click);
            // 
            // btnSua
            // 
            this.btnSua.Location = new System.Drawing.Point(40, 75);
            this.btnSua.Name = "btnSua";
            this.btnSua.Size = new System.Drawing.Size(94, 44);
            this.btnSua.TabIndex = 2;
            this.btnSua.Text = "Sửa";
            this.btnSua.UseVisualStyleBackColor = true;
            this.btnSua.Click += new System.EventHandler(this.btnSua_Click);
            // 
            // gbTXS
            // 
            this.gbTXS.Controls.Add(this.btnThoat);
            this.gbTXS.Controls.Add(this.btnSua);
            this.gbTXS.Controls.Add(this.btnXoa);
            this.gbTXS.Controls.Add(this.btnThem);
            this.gbTXS.Font = new System.Drawing.Font("Microsoft Sans Serif", 9.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.gbTXS.Location = new System.Drawing.Point(985, 79);
            this.gbTXS.Name = "gbTXS";
            this.gbTXS.Size = new System.Drawing.Size(170, 249);
            this.gbTXS.TabIndex = 0;
            this.gbTXS.TabStop = false;
            this.gbTXS.Text = "Chỉnh sửa";
            // 
            // lblMatKhau
            // 
            this.lblMatKhau.AutoSize = true;
            this.lblMatKhau.Location = new System.Drawing.Point(518, 110);
            this.lblMatKhau.Name = "lblMatKhau";
            this.lblMatKhau.Size = new System.Drawing.Size(65, 16);
            this.lblMatKhau.TabIndex = 4;
            this.lblMatKhau.Text = "Mật Khẩu:";
            // 
            // lblSDT
            // 
            this.lblSDT.AutoSize = true;
            this.lblSDT.Location = new System.Drawing.Point(518, 51);
            this.lblSDT.Name = "lblSDT";
            this.lblSDT.Size = new System.Drawing.Size(38, 16);
            this.lblSDT.TabIndex = 3;
            this.lblSDT.Text = "SDT:";
            // 
            // lblGioiTinhNV
            // 
            this.lblGioiTinhNV.AutoSize = true;
            this.lblGioiTinhNV.Location = new System.Drawing.Point(41, 170);
            this.lblGioiTinhNV.Name = "lblGioiTinhNV";
            this.lblGioiTinhNV.Size = new System.Drawing.Size(63, 16);
            this.lblGioiTinhNV.TabIndex = 2;
            this.lblGioiTinhNV.Text = "Giới Tính:";
            // 
            // lblMaNV
            // 
            this.lblMaNV.AutoSize = true;
            this.lblMaNV.Location = new System.Drawing.Point(41, 54);
            this.lblMaNV.Name = "lblMaNV";
            this.lblMaNV.Size = new System.Drawing.Size(81, 16);
            this.lblMaNV.TabIndex = 0;
            this.lblMaNV.Text = "Mã Quản Lý:";
            // 
            // pnHienThi
            // 
            this.pnHienThi.Controls.Add(this.dgvQuanLy);
            this.pnHienThi.Dock = System.Windows.Forms.DockStyle.Bottom;
            this.pnHienThi.Location = new System.Drawing.Point(0, 334);
            this.pnHienThi.Name = "pnHienThi";
            this.pnHienThi.Size = new System.Drawing.Size(1184, 427);
            this.pnHienThi.TabIndex = 3;
            // 
            // lblTieuDe
            // 
            this.lblTieuDe.AutoSize = true;
            this.lblTieuDe.Font = new System.Drawing.Font("Microsoft Sans Serif", 21.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.lblTieuDe.Location = new System.Drawing.Point(521, 30);
            this.lblTieuDe.Name = "lblTieuDe";
            this.lblTieuDe.Size = new System.Drawing.Size(125, 33);
            this.lblTieuDe.TabIndex = 2;
            this.lblTieuDe.Text = "Quản Lý";
            // 
            // gbTTQL
            // 
            this.gbTTQL.Controls.Add(this.cbbGioiTinhQL);
            this.gbTTQL.Controls.Add(this.txtGmail);
            this.gbTTQL.Controls.Add(this.txtMatKhauQL);
            this.gbTTQL.Controls.Add(this.txtSDTQL);
            this.gbTTQL.Controls.Add(this.txtTenQL);
            this.gbTTQL.Controls.Add(this.txtMaQL);
            this.gbTTQL.Controls.Add(this.lblGmail);
            this.gbTTQL.Controls.Add(this.lblMatKhau);
            this.gbTTQL.Controls.Add(this.lblSDT);
            this.gbTTQL.Controls.Add(this.lblGioiTinhNV);
            this.gbTTQL.Controls.Add(this.lblTenNV);
            this.gbTTQL.Controls.Add(this.lblMaNV);
            this.gbTTQL.Font = new System.Drawing.Font("Microsoft Sans Serif", 9.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.gbTTQL.Location = new System.Drawing.Point(26, 79);
            this.gbTTQL.Name = "gbTTQL";
            this.gbTTQL.Size = new System.Drawing.Size(926, 249);
            this.gbTTQL.TabIndex = 1;
            this.gbTTQL.TabStop = false;
            this.gbTTQL.Text = "Thông tin quản lý";
            // 
            // cbbGioiTinhQL
            // 
            this.cbbGioiTinhQL.FormattingEnabled = true;
            this.cbbGioiTinhQL.Items.AddRange(new object[] {
            "Nam",
            "Nữ"});
            this.cbbGioiTinhQL.Location = new System.Drawing.Point(176, 165);
            this.cbbGioiTinhQL.Name = "cbbGioiTinhQL";
            this.cbbGioiTinhQL.Size = new System.Drawing.Size(123, 24);
            this.cbbGioiTinhQL.TabIndex = 13;
            // 
            // lblTenNV
            // 
            this.lblTenNV.AutoSize = true;
            this.lblTenNV.Location = new System.Drawing.Point(41, 109);
            this.lblTenNV.Name = "lblTenNV";
            this.lblTenNV.Size = new System.Drawing.Size(107, 16);
            this.lblTenNV.TabIndex = 1;
            this.lblTenNV.Text = "Họ Tên Quản Lý:";
            // 
            // pnThongTinQL
            // 
            this.pnThongTinQL.Controls.Add(this.lblTieuDe);
            this.pnThongTinQL.Controls.Add(this.gbTTQL);
            this.pnThongTinQL.Controls.Add(this.gbTXS);
            this.pnThongTinQL.Dock = System.Windows.Forms.DockStyle.Fill;
            this.pnThongTinQL.Location = new System.Drawing.Point(0, 0);
            this.pnThongTinQL.Name = "pnThongTinQL";
            this.pnThongTinQL.Size = new System.Drawing.Size(1184, 761);
            this.pnThongTinQL.TabIndex = 2;
            // 
            // frmQuanLy
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(1184, 761);
            this.Controls.Add(this.pnHienThi);
            this.Controls.Add(this.pnThongTinQL);
            this.MaximizeBox = false;
            this.MaximumSize = new System.Drawing.Size(1200, 800);
            this.MinimizeBox = false;
            this.MinimumSize = new System.Drawing.Size(1200, 800);
            this.Name = "frmQuanLy";
            this.Text = "Form1";
            this.Load += new System.EventHandler(this.frmQuanLy_Load);
            ((System.ComponentModel.ISupportInitialize)(this.dgvQuanLy)).EndInit();
            this.gbTXS.ResumeLayout(false);
            this.pnHienThi.ResumeLayout(false);
            this.gbTTQL.ResumeLayout(false);
            this.gbTTQL.PerformLayout();
            this.pnThongTinQL.ResumeLayout(false);
            this.pnThongTinQL.PerformLayout();
            this.ResumeLayout(false);

        }

        #endregion

        private System.Windows.Forms.DataGridView dgvQuanLy;
        private System.Windows.Forms.Button btnXoa;
        private System.Windows.Forms.Button btnThem;
        private System.Windows.Forms.TextBox txtGmail;
        private System.Windows.Forms.TextBox txtMatKhauQL;
        private System.Windows.Forms.TextBox txtSDTQL;
        private System.Windows.Forms.TextBox txtTenQL;
        private System.Windows.Forms.TextBox txtMaQL;
        private System.Windows.Forms.Label lblGmail;
        private System.Windows.Forms.Button btnThoat;
        private System.Windows.Forms.Button btnSua;
        private System.Windows.Forms.GroupBox gbTXS;
        private System.Windows.Forms.Label lblMatKhau;
        private System.Windows.Forms.Label lblSDT;
        private System.Windows.Forms.Label lblGioiTinhNV;
        private System.Windows.Forms.Label lblMaNV;
        private System.Windows.Forms.Panel pnHienThi;
        private System.Windows.Forms.Label lblTieuDe;
        private System.Windows.Forms.GroupBox gbTTQL;
        private System.Windows.Forms.Label lblTenNV;
        private System.Windows.Forms.Panel pnThongTinQL;
        private System.Windows.Forms.ComboBox cbbGioiTinhQL;
    }
}