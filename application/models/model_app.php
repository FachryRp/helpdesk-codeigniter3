<?php

class Model_app extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    //  ================= AUTOMATIC CODE ==================
    public function getkodeticket()
    {
        $query = $this->db->query("select max(id_ticket) as max_code FROM ticket");

        $row = $query->row_array();

        $max_id = $row['max_code'];
        $max_fix = (int) substr($max_id, 9, 4);

        $max_nik = $max_fix + 1;

        $tanggal = $time = date("d");
        $bulan = $time = date("m");
        $tahun = $time = date("Y");

        $nik = "T" . $tahun . $bulan . $tanggal . sprintf("%04s", $max_nik);
        return $nik;
    }

    public function getkodekaryawan()
    {
        $query = $this->db->query("select max(nik) as max_code FROM karyawan");

        $row = $query->row_array();

        $max_id = $row['max_code'];
        $max_fix = (int) substr($max_id, 1, 4);

        $max_nik = $max_fix + 1;

        $nik = "K" . sprintf("%04s", $max_nik);
        return $nik;
    }

    public function getkodeteknisi()
    {
        $query = $this->db->query("select max(id_teknisi) as max_code FROM teknisi");

        $row = $query->row_array();

        $max_id = $row['max_code'];
        $max_fix = (int) substr($max_id, 1, 4);

        $max_id_teknisi = $max_fix + 1;

        $id_teknisi = "T" . sprintf("%04s", $max_id_teknisi);
        return $id_teknisi;
    }

    public function getkodeuser()
    {
        $query = $this->db->query("select max(id_user) as max_code FROM user");

        $row = $query->row_array();

        $max_id = $row['max_code'];
        $max_fix = (int) substr($max_id, 1, 4);

        $max_id_user = $max_fix + 1;

        $id_user = "U" . sprintf("%04s", $max_id_user);
        return $id_user;
    }

    public function datajabatan()
    {
        $query = $this->db->query('SELECT * FROM jabatan');
        return $query->result();
    }

    public function datakaryawan()
    {
        $query = $this->db->query('SELECT A.nama, A.nik, A.alamat, A.jk, B.nama_jabatan, D.nama_dept,E.nama_divisi
                               FROM karyawan A inner JOIN jabatan B ON B.id_jabatan = A.id_jabatan
                               
                               left JOIN departemen D ON D.id_dept = A.id_dept
                               inner join divisi E on E.id_divisi = D.id_divisi');
        return $query->result();
    }
    public function datakaryawan1()
    {
        $query = $this->db->query('SELECT A.nama, A.nik, A.alamat, A.jk, D.nama_department
                               FROM tb_pegawai A LEFT JOIN tb_unit B ON B.id_unit = A.unit_kerja
                               
                               left JOIN tb_departement D ON D.id_departement = A.id_department');
        //    inner join tb_organisasi E on E.id = D.id');
        return $query->result();
    }

    public function datalist_ticket()
    {

        $query = $this->db->query("SELECT D.nama, F.nama_dept, A.status, A.id_ticket, A.tanggal, B.nama_sub_kategori, C.nama_kategori
        FROM ticket A 
        left JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori
        left JOIN kategori C ON C.id_kategori = B.id_kategori
        left JOIN karyawan D ON D.nik = A.reported
        left JOIN bagian_departemen E ON E.id_bagian_dept = D.id_bagian_dept
        left JOIN departemen F ON F.id_dept = E.id_dept
        WHERE A.status IN (2,3,4,5,6)");
        return $query->result();
    }
    public function datalist_ticket1()
    {

        $query = $this->db->query("SELECT D.nama_karyawan, A.status, A.id_ticket, A.tanggal, B.nama_sub_kategori, C.nama_kategori, E.nama_dept, U.nama, N.nama_unit
        FROM ticket A 
        left JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori
        left JOIN kategori C ON C.id_kategori = B.id_kategori
        left JOIN karyawan D ON D.nik = A.reported
        left JOIN departemen E ON E.id_dept = D.id_dept
        left JOIN divisi F ON F.id_divisi = E.id_divisi
        left JOIN tb_pegawai U ON U.nik = A.reported
        left JOIN tb_unit N ON N.id_unit = U.unit_kerja
        WHERE A.status IN (2,3,4,5,6,7,8,9,10) order by id_ticket asc");
        return $query->result();
    }

    public function data_trackingticket1($id)
    {

        $query = $this->db->query("SELECT A.tanggal, A.status, A.deskripsi, B.nama_karyawan
                                   FROM tracking A 
                                   INNER JOIN karyawan B ON B.nik = A.id_user
                                   inner JOIN ticket C ON C.id_ticket = A.id_ticket
                                   WHERE A.id_ticket ='$id'");
        return $query->result();
    }
    public function data_trackingticket($id)
    {

        $query = $this->db->query("SELECT A.tanggal, A.status, A.deskripsi, A.nama
                                   FROM tracking A 
                                --    INNER JOIN karyawan B ON B.nik = A.id_user
                                --    left Join tb_pegawai D ON D.nik = A.id_user
                                   inner JOIN ticket C ON C.id_ticket = A.id_ticket
                                   WHERE A.id_ticket ='$id' order by tanggal asc");
        return $query->result();
    }


    public function datainformasi()
    {

        $query = $this->db->query("SELECT A.tanggal, A.subject, A.pesan, C.nama_karyawan, A.id_informasi, D.nama
                                   FROM informasi A 
                                   left JOIN karyawan C ON C.nik =  A.id_user
                                   left JOIN tb_pegawai D ON D.nik =  A.id_user
                                   WHERE A.status = 1 order by tanggal desc");
        return $query->result();
    }

    public function datamyticket($id)
    {
        $query = $this->db->query("SELECT A.progress, A.tanggal_proses, A.tanggal_solved, A.id_teknisi, D.feedback, A.status, A.id_ticket, A.tanggal, B.nama_sub_kategori, C.nama_kategori
                                   FROM ticket A 
                                   left JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori
                                   left JOIN kategori C ON C.id_kategori = B.id_kategori 
                                   left JOIN history_feedback D ON D.id_ticket = A.id_ticket
                                   WHERE A.reported = '$id' ");
        return $query->result();
    }


    public function datamyassignment($id)
    {
        $query = $this->db->query("SELECT A.progress, A.status, A.id_ticket, A.reported, A.tanggal,A.problem_summary, A.problem_detail, B.nama_sub_kategori, C.nama_kategori
                                   FROM ticket A 
                                   left JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori
                                   left JOIN kategori C ON C.id_kategori = B.id_kategori
                                   left JOIN karyawan D ON D.nik = A.reported
                                   left JOIN teknisi E ON E.id_teknisi = A.id_teknisi
                                --    left JOIN karyawan F ON F.nik = E.nik
                                   left JOIN tb_pegawai G ON G.nik = E.nik
                                   WHERE G.nik = '$id'
                                   AND A.status IN (3,4,5,6,7,8,9,10)
                                   ");
        return $query->result();
    }
    // left JOIN bagian_departemen E ON E.id_bagian_dept = D.id_bagian_dept WHERE A.status = 1 OR  A.status= 0");

    public function dataapproval()
    {
        $query = $this->db->query("SELECT A.status, D.nama ,A.status, A.id_ticket, A.tanggal, B.nama_sub_kategori, C.nama_kategori 
        FROM ticket A 
        left JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori 
        left JOIN kategori C ON C.id_kategori = B.id_kategori
        left JOIN karyawan D ON D.nik = A.reported 
        left JOIN bagian_departemen E ON E.id_bagian_dept = D.id_bagian_dept WHERE A.status = 1 OR  A.status = 0");
        return $query->result();
    }
    public function dataapprovalnew()
    {
        $query = $this->db->query(
            "SELECT A.status, D.nama_karyawan, A.status, A.id_ticket, A.tanggal, B.nama_sub_kategori, C.nama_kategori, U.nama
        FROM ticket A 
        left JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori 
        left JOIN kategori C ON C.id_kategori = B.id_kategori
        left JOIN karyawan D ON D.nik = A.reported 
        left join tb_pegawai U ON U.nik = A.reported
        left JOIN tb_unit E ON E.id_unit = U.unit_kerja WHERE A.status = 1 OR  A.status= 0 order by id_ticket asc"
            // left JOIN divisi F ON F.id_divisi = E.id_divisi  
        );
        return $query->result();
    }

    public function datadepartemen()
    {
        //$query = $this->db->query('SELECT * FROM departemen');
        //return $query->result();
        $query = $this->db->query('SELECT a.id_dept,a.nama_dept,b.id_divisi,b.nama_divisi FROM departemen a inner JOIN divisi b ON a.id_divisi = b.id_divisi ');
        return $query->result();
    }
    public function datadivisi()
    {
        $query = $this->db->query('SELECT * FROM divisi');
        return $query->result();
    }

    public function databagiandepartemen()
    {
        $query = $this->db->query('SELECT * FROM bagian_departemen A LEFT JOIN departemen B ON B.id_dept = A.id_dept ');
        return $query->result();
    }

    public function datakondisi()
    {
        $query = $this->db->query('SELECT * FROM kondisi');
        return $query->result();
    }

    public function datateknisi()
    {
        $query = $this->db->query('SELECT A.point, A.id_teknisi, B.nama_karyawan, B.jk, C.nama_kategori, A.status, A.point, D.nama, D.jk FROM teknisi A 
                                LEFT JOIN karyawan B ON B.nik = A.nik
                                LEFT JOIN kategori C ON C.id_kategori = A.id_kategori
                                LEFT JOIN tb_pegawai D ON D.nik = A.nik
                                 ');
        return $query->result();
    }


    public function datareportteknisi($id)
    {
        $query = $this->db->query(
            "SELECT A.progress, A.tanggal_proses, A.status, A.problem_summary, B.nama_karyawan, D.nama_kategori, F.nama_dept  FROM ticket A 
                                LEFT JOIN karyawan B ON B.nik = A.reported
                                LEFT JOIN sub_kategori C ON C.id_sub_kategori = A.id_sub_kategori
                                LEFT JOIN kategori D ON D.id_kategori = C.id_kategori
                                LEFT JOIN bagian_departemen E ON E.id_bagian_dept = B.id_bagian_dept
                                LEFT JOIN departemen F ON F.id_dept = E.id_dept
                                WHERE id_teknisi = '$id'"
        );
        return $query->result();
    }
    public function datareportteknisi1($id)
    {
        $query = $this->db->query(
            "SELECT A.progress, A.tanggal_proses, A.status, A.problem_summary, D.nama_kategori, J.nama, J.unit_kerja, U.nama_unit FROM ticket A  
            LEFT JOIN sub_kategori C ON C.id_sub_kategori = A.id_sub_kategori 
            LEFT JOIN kategori D ON D.id_kategori = C.id_kategori 
            LEFT JOIN tb_pegawai J ON J.nik = A.reported
            inner JOIN tb_unit U ON U.id_unit = J.unit_kerja
             WHERE id_teknisi = '$id'"
        );
        return $query->result();
    }


    public function datauser()
    {
        //$query = $this->db->query('SELECT A.username, A.level, A.id_user, B.nik, B.nama, A.password, C.nama_divisi, D.nama_dept
        //FROM user A LEFT JOIN karyawan B ON B.nik = A.username 
        //LEFT JOIN divisi C ON C.id_divisi = C.id_divisi
        //LEFT JOIN departemen D ON D.id_dept = D.id_dept
        //');
        $query = $this->db->query('SELECT A.username, A.level, A.id_user, B.nik, B.nama, A.password, C.id_dept, C.nama_dept, D.nama_divisi, D.id_divisi
                                FROM user A LEFT JOIN karyawan B ON B.nik = A.username
                                INNER JOIN departemen C ON C.id_dept = B.id_dept
                                INNER JOIN divisi D ON D.id_divisi = C.id_divisi
                                 ');

        return $query->result();
    }
    public function datauser1()
    {
        $query = $this->db->query('SELECT A.hak_akses, A.id_user, A.nama_user, B.nik, A.password
                                FROM tb_user A LEFT JOIN tb_pegawai B ON B.nik = A.id_user
                                 ');

        return $query->result();
    }
    public function datauser2()
    {
        // $query = $this->db->query('SELECT  A.nik, A.nama, B.id_user,A.unit_kerja
        //                         FROM tb_pegawai A LEFT JOIN tb_user B ON B.id_user = A.nik
        //                         LEFT JOIN tb_unit C ON C.nama = A.unit_kerja
        //                          ');
        $query = $this->db->query('SELECT  A.nik, A.nama,A.unit_kerja, A.id_peg, B.hak_akses, B.nama_user, B.password
                                FROM tb_pegawai A LEFT JOIN tb_user B ON B.id_user = A.nik
                                LEFT JOIN tb_unit C ON C.nama = A.unit_kerja
                                 ');

        return $query->result();
    }

    // raju check
    public function datachat()
    {
        $query = $this->db->query('SELECT * FROM livechat WHERE id_pesan = 1');
        return $query->result();
    }
    public function datakategori()
    {
        $query = $this->db->query('SELECT * FROM kategori');
        return $query->result();
    }

    public function dataassignment($id)
    {
        $query = $this->db->query('SELECT A.status, D.nama, C.id_kategori, A.id_ticket, A.tanggal, A.problem_summary, A.problem_detail, B.nama_sub_kategori, C.nama_kategori
                FROM ticket A 
                LEFT JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori
                LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
                LEFT JOIN karyawan D ON D.nik = A.reported 
                WHERE A.id_teknisi = "$id"');
        return $query->result();
    }

    public function datasubkategori()
    {
        $query = $this->db->query('SELECT * FROM sub_kategori A LEFT JOIN kategori B ON B.id_kategori = A.id_kategori ');
        return $query->result();
    }


    public function dropdown_departemen()
    {
        $sql = "SELECT * FROM Departemen ORDER BY nama_dept";
        $query = $this->db->query($sql);

        $value[''] = '-- PILIH --';
        foreach ($query->result() as $row) {
            $value[$row->id_dept] = $row->nama_dept;
        }
        return $value;
    }

    public function dropdown_kategori()
    {
        $sql = "SELECT * FROM kategori ORDER BY nama_kategori";
        $query = $this->db->query($sql);

        $value[''] = '-- PILIH --';
        foreach ($query->result() as $row) {
            $value[$row->id_kategori] = $row->nama_kategori;
        }
        return $value;
    }

    public function dropdown_karyawan()
    {
        $sql = "SELECT A.nama_karyawan, A.nik FROM karyawan A 
                INNER JOIN departemen C ON C.id_dept = A.id_dept
                INNER JOIN divisi D ON D.id_divisi = C.id_divisi
                ORDER BY nama_karyawan";
        $query = $this->db->query($sql);

        $value[''] = '-- PILIH --';
        foreach ($query->result() as $row) {
            $value[$row->nik] = $row->nama_karyawan;
        }
        return $value;
    }
    // public function dropdown_karyawan1()
    // {
    //     $sql = "SELECT A.nama, A.nik FROM tb_pegawai A 
    //             -- INNER JOIN departemen C ON C.id_dept = A.id_dept
    //             INNER JOIN tb_unit D ON D.id_unit = A.unit_kerja
    //             ORDER BY nama";
    //     $query = $this->db->query($sql);

    //     $value[''] = '-- PILIH --';
    //     foreach ($query->result() as $row) {
    //         $value[$row->nik] = $row->nama;
    //     }
    //     return $value;
    // }

    public function dropdown_jabatan()
    {
        $sql = "SELECT * FROM jabatan ORDER BY nama_jabatan";
        $query = $this->db->query($sql);

        $value[''] = '-- PILIH --';
        foreach ($query->result() as $row) {
            $value[$row->id_jabatan] = $row->nama_jabatan;
        }
        return $value;
    }

    public function dropdown_kondisi()
    {
        $sql = "SELECT * FROM kondisi ORDER BY nama_kondisi";
        $query = $this->db->query($sql);

        $value[''] = '-- PILIH --';
        foreach ($query->result() as $row) {
            $value[$row->id_kondisi] = $row->nama_kondisi . "  -  (TARGET PROSES " . $row->waktu_respon . " " . "HARI)";
        }
        return $value;
    }

    public function dropdown_bagian_departemen($id_departemen)
    {
        $sql = "SELECT * FROM bagian_departemen where id_dept ='$id_departemen' ORDER BY nama_bagian_dept";
        $query = $this->db->query($sql);

        $value[''] = '-- PILIH --';
        foreach ($query->result() as $row) {
            $value[$row->id_bagian_dept] = $row->nama_bagian_dept;
        }
        return $value;
    }

    public function dropdown_sub_kategori($id_kategori)
    {
        $sql = "SELECT * FROM sub_kategori where id_kategori ='$id_kategori' ORDER BY nama_sub_kategori";
        $query = $this->db->query($sql);

        $value[''] = '-- PILIH --';
        foreach ($query->result() as $row) {
            $value[$row->id_sub_kategori] = $row->nama_sub_kategori;
        }
        return $value;
    }

    function dropdown_teknisi($id_kategori)
    {

        $sql = "SELECT A.id_teknisi, B.nama_karyawan, B.jk, C.nama_kategori, A.status, A.point, D.nama FROM teknisi A 
                                LEFT JOIN karyawan B ON B.nik = A.nik
                                LEFT JOIN kategori C ON C.id_kategori = A.id_kategori
                                LEFT JOIN tb_pegawai D ON D.nik = A.nik
                                WHERE A.id_kategori ='$id_kategori'";
        $query = $this->db->query($sql);

        $value[''] = '-- PILIH --';
        foreach ($query->result() as $row) {
            $value[$row->id_teknisi] = ($row->nama_karyawan) . ($row->nama);
        }
        return $value;
    }
    function dropdown_teknisi1($id_kategori)
    {

        $sql = "SELECT A.id_teknisi, B.nama_karyawan, B.jk, C.nama_kategori, A.status, A.point FROM teknisi A 
                                LEFT JOIN karyawan B ON B.nik = A.nik
                                LEFT JOIN kategori C ON C.id_kategori = A.id_kategori
                                WHERE A.id_kategori ='$id_kategori'";
        $query = $this->db->query($sql);

        $value[''] = '-- PILIH --';
        foreach ($query->result() as $row) {
            $value[$row->id_teknisi] = $row->nama_karyawan;
        }
        return $value;
    }


    public function dropdown_jk()
    {
        $value[''] = '--PILIH--';
        $value['LAKI-LAKI'] = 'LAKI-LAKI';
        $value['PEREMPUAN'] = 'PEREMPUAN';

        return $value;
    }

    public function dropdown_level()
    {
        $value[''] = '--PILIH--';
        $value['ADMIN'] = 'ADMIN';
        $value['TEKNISI'] = 'TEKNISI';
        $value['USER'] = 'USER';
        $value['PEpegawai'] = 'pegawai';

        return $value;
    }
    public function dropdown_divisi()
    {
        $sql = "SELECT * FROM divisi ORDER BY nama_divisi";
        $query = $this->db->query($sql);

        $value[''] = '-- PILIH --';
        foreach ($query->result() as $row) {
            $value[$row->id_divisi] = $row->nama_divisi;
        }
        return $value;
    }
    public function dropdown_departemen2($id_divisi)
    {
        //$sql = "SELECT * FROM departemen where id_divisi ='$id_divisi' ORDER BY nama_dept;
        //$query = $this->db->query($sql);
        //$value[''] = '-- PILIH --';
        //foreach ($query->result() as $row) {
        // $value[$row->id_divisi] = $row->nama_dept;
        // }
        // return $value;
    }

    public function divisi_tampil()
    {
        return $this->db->get('divisi')->result();
    }

    public function departemen_tampil($id_divisi)
    {
        $this->db->where('id_divisi', $id_divisi);
        $result = $this->db->get('departemen')->result(); // Tampilkan semua data kota berdasarkan id provinsi       
        return $result;
    }
    public function get_div()
    {
        $sql = "SELECT * FROM divisi ORDER BY nama_divisi";
        $query = $this->db->query($sql);

        $value[''] = '-- PILIH --';
        foreach ($query->result() as $row) {
            $value[$row->id_divisi] = $row->nama_divisi;
        }
        return $value;
    }

    function get_departemen($id_divisi)
    {
        $sql = "SELECT * FROM departemen where id_divisi = '$id_divisi' ORDER BY nama_dept";
        $query = $this->db->query($sql);

        $value[''] = '-- PILIH --';
        foreach ($query->result() as $row) {
            $value[$row->id_dept] = $row->nama_dept;
        }
        return $value;
    }
    function getdivisi()
    {
        $divisi = $this->$this->db->get('divisi')->result_array();
        return $divisi;
    }
    public function dataapproval_requestor($id)
    {
        $query = $this->db->query("SELECT A.progress, A.tanggal_proses, A.tanggal_solved, A.id_teknisi, A.status, A.id_ticket, A.tanggal,  A.deskripsi, B.nama_sub_kategori, C.nama_kategori
                                   FROM ticket A 
                                   left JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori
                                   left JOIN kategori C ON C.id_kategori = B.id_kategori 
                                --    inner join tracking E ON E.keterangan_pending = A.keterangan_pending
                                --    inner join tracking F ON F.deskripsi = A.deskripsi
                                   WHERE A.reported = '$id' 
                                --    AND A.status = 8 
                                  AND A.status IN (6,7,8)
                                   ");
        return $query->result();
    }
    public function datamyticket1($id)
    {
        $query = $this->db->query("SELECT A.progress, A.tanggal_proses, A.tanggal_solved, A.id_teknisi, D.feedback, A.status, A.id_ticket, A.tanggal, B.nama_sub_kategori, C.nama_kategori
                                   FROM ticket A 
                                   left JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori
                                   left JOIN kategori C ON C.id_kategori = B.id_kategori 
                                   left JOIN history_feedback D ON D.id_ticket = A.id_ticket
                                   WHERE A.reported = '$id' ");
        return $query->result();
    }
    public function dataapproval_requestor_adm()
    {
        $query = $this->db->query("SELECT A.progress, A.tanggal_proses, A.tanggal_solved, A.id_teknisi, A.status, A.id_ticket, A.tanggal, A.keterangan_pending, A.deskripsi, B.nama_sub_kategori, C.nama_kategori
                                   FROM ticket A 
                                   left JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori
                                   left JOIN kategori C ON C.id_kategori = B.id_kategori 
                                   left JOIN karyawan D ON D.nik = A.reported 
                                --    inner join tracking E ON E.keterangan_pending = A.keterangan_pending
                                --    inner join tracking F ON F.deskripsi = A.deskripsi
                                WHERE A.status IN (6, 7, 8)");

        //     "SELECT A.status, D.nama ,A.id_ticket, A.keterangan_pending, A.tanggal, A.deskripsi, B.nama_sub_kategori, C.nama_kategori 
        // FROM ticket A 
        // left JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori 
        // left JOIN kategori C ON C.id_kategori = B.id_kategori
        // left JOIN karyawan D ON D.nik = A.reported 
        // left JOIN departemen E ON E.id_dept = D.id_dept WHERE A.status IN (6,8)"
        // left JOIN departemen E ON E.id_dept = D.id_dept WHERE A.status = 8 OR A.status = 6"
        // );
        return $query->result();
    }
    // public function datachat1()
    // {
    //     $sql = "SELECT * FROM livechat where id_pesan = 'T202311160033'";
    //     $query = $this->db->query($sql);
    //     return $query->result();
    // }
}
