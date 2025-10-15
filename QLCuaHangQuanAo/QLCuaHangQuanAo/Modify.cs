using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Data;
using System.Data.SqlClient;

namespace QLCuaHangQuanAo
{
    internal class Modify
    {
        public Modify() 
        {
        }
        SqlDataAdapter dataAdapter;
        SqlCommand sqlCommand;
        SqlDataReader sqlReader;
        public DataTable Table(String query)
        {
            DataTable dataTable = new DataTable();
            using (SqlConnection sqlConnection= Connection.GetSqlConnection())
            {
                sqlConnection.Open();
                dataAdapter = new SqlDataAdapter(query,sqlConnection);
                dataAdapter.Fill(dataTable);
                sqlConnection.Close();
            }
            return dataTable;
        }

        public void Command(String query)
        {
            using (SqlConnection sqlConnection = Connection.GetSqlConnection())
            {
                sqlConnection.Open();
                sqlCommand =new SqlCommand(query,sqlConnection);
                sqlCommand.ExecuteNonQuery();
                sqlConnection.Close();
            }
        }
        
    }
}
