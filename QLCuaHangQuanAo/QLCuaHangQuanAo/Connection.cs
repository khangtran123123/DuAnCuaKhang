using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Data.SqlClient;

namespace QLCuaHangQuanAo
{
    internal class Connection
    {
        private static string stringConnection = "Data Source=(LocalDB)\\MSSQLLocalDB;AttachDbFilename=\"D:\\LapTrinh net\\backUpDoAn2\\QLCuaHangQuanAo\\QLCuaHangQuanAo\\QLCuaHangQuanAo.mdf\";Integrated Security=True";
        public static  SqlConnection GetSqlConnection()
        {
            return new SqlConnection(stringConnection);
        }
        
    }
}
