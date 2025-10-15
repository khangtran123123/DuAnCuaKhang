namespace QLCuaHangQuanAo
{
    partial class frmMain
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
            this.pnNut = new System.Windows.Forms.Panel();
            this.btnHoaDon = new System.Windows.Forms.Button();
            this.btnNCC = new System.Windows.Forms.Button();
            this.btnKhach = new System.Windows.Forms.Button();
            this.btnBanHang = new System.Windows.Forms.Button();
            this.btnNhapSP = new System.Windows.Forms.Button();
            this.btnKho = new System.Windows.Forms.Button();
            this.btnQL = new System.Windows.Forms.Button();
            this.pnHienThi = new System.Windows.Forms.Panel();
            this.lblChuDe = new System.Windows.Forms.Label();
            this.pbAnhTong = new System.Windows.Forms.PictureBox();
            this.pnNut.SuspendLayout();
            this.pnHienThi.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.pbAnhTong)).BeginInit();
            this.SuspendLayout();
            // 
            // pnNut
            // 
            this.pnNut.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(192)))), ((int)(((byte)(255)))), ((int)(((byte)(255)))));
            this.pnNut.Controls.Add(this.pbAnhTong);
            this.pnNut.Controls.Add(this.btnHoaDon);
            this.pnNut.Controls.Add(this.btnNCC);
            this.pnNut.Controls.Add(this.btnKhach);
            this.pnNut.Controls.Add(this.btnBanHang);
            this.pnNut.Controls.Add(this.btnNhapSP);
            this.pnNut.Controls.Add(this.btnKho);
            this.pnNut.Controls.Add(this.btnQL);
            this.pnNut.Dock = System.Windows.Forms.DockStyle.Left;
            this.pnNut.Location = new System.Drawing.Point(0, 0);
            this.pnNut.Name = "pnNut";
            this.pnNut.Size = new System.Drawing.Size(249, 770);
            this.pnNut.TabIndex = 0;
            // 
            // btnHoaDon
            // 
            this.btnHoaDon.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(255)))), ((int)(((byte)(255)))), ((int)(((byte)(192)))));
            this.btnHoaDon.Font = new System.Drawing.Font("Microsoft Sans Serif", 14.25F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.btnHoaDon.Image = global::QLCuaHangQuanAo.Properties.Resources.mindset__1_;
            this.btnHoaDon.ImageAlign = System.Drawing.ContentAlignment.MiddleLeft;
            this.btnHoaDon.Location = new System.Drawing.Point(3, 464);
            this.btnHoaDon.Name = "btnHoaDon";
            this.btnHoaDon.Size = new System.Drawing.Size(246, 60);
            this.btnHoaDon.TabIndex = 6;
            this.btnHoaDon.Text = "Hóa Đơn";
            this.btnHoaDon.UseVisualStyleBackColor = false;
            this.btnHoaDon.Click += new System.EventHandler(this.btnNV_Click);
            // 
            // btnNCC
            // 
            this.btnNCC.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(255)))), ((int)(((byte)(255)))), ((int)(((byte)(192)))));
            this.btnNCC.Font = new System.Drawing.Font("Microsoft Sans Serif", 14.25F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.btnNCC.Image = global::QLCuaHangQuanAo.Properties.Resources.warehouse__1_;
            this.btnNCC.ImageAlign = System.Drawing.ContentAlignment.MiddleLeft;
            this.btnNCC.Location = new System.Drawing.Point(3, 398);
            this.btnNCC.Name = "btnNCC";
            this.btnNCC.Size = new System.Drawing.Size(246, 60);
            this.btnNCC.TabIndex = 5;
            this.btnNCC.Text = "Nhà cung cấp";
            this.btnNCC.UseVisualStyleBackColor = false;
            this.btnNCC.Click += new System.EventHandler(this.btnNCC_Click);
            // 
            // btnKhach
            // 
            this.btnKhach.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(255)))), ((int)(((byte)(255)))), ((int)(((byte)(192)))));
            this.btnKhach.Font = new System.Drawing.Font("Microsoft Sans Serif", 14.25F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.btnKhach.Image = global::QLCuaHangQuanAo.Properties.Resources.guest__1_;
            this.btnKhach.ImageAlign = System.Drawing.ContentAlignment.MiddleLeft;
            this.btnKhach.Location = new System.Drawing.Point(3, 596);
            this.btnKhach.Name = "btnKhach";
            this.btnKhach.Size = new System.Drawing.Size(246, 60);
            this.btnKhach.TabIndex = 4;
            this.btnKhach.Text = "Khách";
            this.btnKhach.UseVisualStyleBackColor = false;
            this.btnKhach.Click += new System.EventHandler(this.btnKhach_Click);
            // 
            // btnBanHang
            // 
            this.btnBanHang.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(255)))), ((int)(((byte)(255)))), ((int)(((byte)(192)))));
            this.btnBanHang.Font = new System.Drawing.Font("Microsoft Sans Serif", 14.25F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.btnBanHang.Image = global::QLCuaHangQuanAo.Properties.Resources.trade__1_;
            this.btnBanHang.ImageAlign = System.Drawing.ContentAlignment.MiddleLeft;
            this.btnBanHang.Location = new System.Drawing.Point(3, 530);
            this.btnBanHang.Name = "btnBanHang";
            this.btnBanHang.Size = new System.Drawing.Size(246, 60);
            this.btnBanHang.TabIndex = 3;
            this.btnBanHang.Text = "Bán hàng";
            this.btnBanHang.UseVisualStyleBackColor = false;
            this.btnBanHang.Click += new System.EventHandler(this.btnBanHang_Click);
            // 
            // btnNhapSP
            // 
            this.btnNhapSP.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(255)))), ((int)(((byte)(255)))), ((int)(((byte)(192)))));
            this.btnNhapSP.Font = new System.Drawing.Font("Microsoft Sans Serif", 14.25F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.btnNhapSP.Image = global::QLCuaHangQuanAo.Properties.Resources.packaging__1_;
            this.btnNhapSP.ImageAlign = System.Drawing.ContentAlignment.MiddleLeft;
            this.btnNhapSP.Location = new System.Drawing.Point(3, 332);
            this.btnNhapSP.Name = "btnNhapSP";
            this.btnNhapSP.Size = new System.Drawing.Size(246, 60);
            this.btnNhapSP.TabIndex = 2;
            this.btnNhapSP.Text = "Nhập Sản Phẩm";
            this.btnNhapSP.UseVisualStyleBackColor = false;
            this.btnNhapSP.Click += new System.EventHandler(this.btnNhapSP_Click);
            // 
            // btnKho
            // 
            this.btnKho.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(255)))), ((int)(((byte)(255)))), ((int)(((byte)(192)))));
            this.btnKho.Font = new System.Drawing.Font("Microsoft Sans Serif", 14.25F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.btnKho.Image = global::QLCuaHangQuanAo.Properties.Resources.stock__1_;
            this.btnKho.ImageAlign = System.Drawing.ContentAlignment.MiddleLeft;
            this.btnKho.Location = new System.Drawing.Point(3, 266);
            this.btnKho.Name = "btnKho";
            this.btnKho.Size = new System.Drawing.Size(246, 60);
            this.btnKho.TabIndex = 1;
            this.btnKho.Text = "Kho";
            this.btnKho.UseVisualStyleBackColor = false;
            this.btnKho.Click += new System.EventHandler(this.btnKho_Click);
            // 
            // btnQL
            // 
            this.btnQL.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(255)))), ((int)(((byte)(255)))), ((int)(((byte)(192)))));
            this.btnQL.Font = new System.Drawing.Font("Microsoft Sans Serif", 14.25F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.btnQL.Image = global::QLCuaHangQuanAo.Properties.Resources.management__1_;
            this.btnQL.ImageAlign = System.Drawing.ContentAlignment.MiddleLeft;
            this.btnQL.Location = new System.Drawing.Point(3, 200);
            this.btnQL.Name = "btnQL";
            this.btnQL.Size = new System.Drawing.Size(246, 60);
            this.btnQL.TabIndex = 0;
            this.btnQL.Text = "Quản Lý";
            this.btnQL.UseVisualStyleBackColor = false;
            this.btnQL.Click += new System.EventHandler(this.btnQL_Click);
            // 
            // pnHienThi
            // 
            this.pnHienThi.BackgroundImage = global::QLCuaHangQuanAo.Properties.Resources.AnhChinh2;
            this.pnHienThi.BackgroundImageLayout = System.Windows.Forms.ImageLayout.Stretch;
            this.pnHienThi.Controls.Add(this.lblChuDe);
            this.pnHienThi.Dock = System.Windows.Forms.DockStyle.Fill;
            this.pnHienThi.Location = new System.Drawing.Point(249, 0);
            this.pnHienThi.Name = "pnHienThi";
            this.pnHienThi.Size = new System.Drawing.Size(1194, 770);
            this.pnHienThi.TabIndex = 1;
            // 
            // lblChuDe
            // 
            this.lblChuDe.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(255)))), ((int)(((byte)(255)))), ((int)(((byte)(192)))));
            this.lblChuDe.Font = new System.Drawing.Font("Microsoft Sans Serif", 36F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.lblChuDe.ForeColor = System.Drawing.Color.Red;
            this.lblChuDe.Location = new System.Drawing.Point(0, 0);
            this.lblChuDe.Name = "lblChuDe";
            this.lblChuDe.Size = new System.Drawing.Size(1235, 61);
            this.lblChuDe.TabIndex = 0;
            this.lblChuDe.Text = "Cửa Hàng Quần Áo";
            this.lblChuDe.TextAlign = System.Drawing.ContentAlignment.MiddleCenter;
            // 
            // pbAnhTong
            // 
            this.pbAnhTong.BackgroundImage = global::QLCuaHangQuanAo.Properties.Resources.clothes__1_;
            this.pbAnhTong.Location = new System.Drawing.Point(0, 0);
            this.pbAnhTong.Name = "pbAnhTong";
            this.pbAnhTong.Size = new System.Drawing.Size(248, 200);
            this.pbAnhTong.TabIndex = 7;
            this.pbAnhTong.TabStop = false;
            // 
            // frmMain
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(1443, 770);
            this.Controls.Add(this.pnHienThi);
            this.Controls.Add(this.pnNut);
            this.MaximizeBox = false;
            this.MaximumSize = new System.Drawing.Size(1459, 809);
            this.MinimizeBox = false;
            this.MinimumSize = new System.Drawing.Size(1459, 809);
            this.Name = "frmMain";
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
            this.Text = "frmMain";
            this.pnNut.ResumeLayout(false);
            this.pnHienThi.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.pbAnhTong)).EndInit();
            this.ResumeLayout(false);

        }

        #endregion

        private System.Windows.Forms.Panel pnNut;
        private System.Windows.Forms.Panel pnHienThi;
        private System.Windows.Forms.Button btnHoaDon;
        private System.Windows.Forms.Button btnNCC;
        private System.Windows.Forms.Button btnKhach;
        private System.Windows.Forms.Button btnBanHang;
        private System.Windows.Forms.Button btnNhapSP;
        private System.Windows.Forms.Button btnKho;
        private System.Windows.Forms.Button btnQL;
        private System.Windows.Forms.Label lblChuDe;
        private System.Windows.Forms.PictureBox pbAnhTong;
    }
}