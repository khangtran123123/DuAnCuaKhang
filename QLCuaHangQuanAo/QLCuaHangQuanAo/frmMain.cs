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
    public partial class frmMain : Form
    {
        public frmMain()
        {
            InitializeComponent();
        }

        private Form currentFormChild;
        private void OpenChildForm(Form childForm)
        {
            if (currentFormChild != null)
            {
                currentFormChild.Close();
            }
            currentFormChild = childForm;
            childForm.TopLevel = false;
            childForm.FormBorderStyle = FormBorderStyle.None;
            childForm.Dock = DockStyle.Fill;
            pnHienThi.Controls.Add(childForm);
            pnHienThi.Tag = childForm;
            childForm.BringToFront();
            childForm.Show();
        }

        private void btnNV_Click(object sender, EventArgs e)
        {
            
            OpenChildForm(new frmHoaDon());
        }

        private void btnQL_Click(object sender, EventArgs e)
        {
            OpenChildForm(new frmQuanLy());
        }

        private void btnKho_Click(object sender, EventArgs e)
        {
            OpenChildForm(new frmKho());
        }

        private void btnNhapSP_Click(object sender, EventArgs e)
        {
            OpenChildForm(new frmNhapSP());
        }

        private void btnKhach_Click(object sender, EventArgs e)
        {
            OpenChildForm(new frmKhach());
        }

        private void btnNCC_Click(object sender, EventArgs e)
        {
            OpenChildForm(new frmNCC());
        }

        private void btnBanHang_Click(object sender, EventArgs e)
        {
            OpenChildForm(new frmBanHang());
        }

        
    }
}
