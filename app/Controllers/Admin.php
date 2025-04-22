<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\MoldItemModel;
use App\Models\DetailMold;
use App\Models\HistoryPerbaikanModel;
use App\Models\LampiranDimensiModel;
use App\Models\LampiranVisualModel;

class Admin extends BaseController
{
    public function dashboard()
    {
        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }

        $TotalItems = new MoldItemModel();
        $TotalUser = new UserModel();
        $GetTotalItem = $TotalItems->TotalAllItems();
        $GetTotalUser = $TotalUser->TotalUser();
        $Data['totalItem'] = $GetTotalItem;
        $Data['totalUser'] = $GetTotalUser;

        return view('pages/admin/dashboard', $Data);
    }



    public function Form_Verifikasi()
    {
        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        $moldItemModel = new MoldItemModel();

        // Mengambil semua item dari model
        $items = $moldItemModel->getAllItems();

        // Meneruskan data ke tampilan
        $data['items'] = $items;


        return view('pages/admin/form', $data);
    }

    public function userlist()
    {
        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        $user = new UserModel();
        $GetUser = $user->getUser();
        $dataUser['data'] = $GetUser;
        return view('pages/admin/userlist', $dataUser);
    }

    public function manage($userId)
    {
        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        // Membuat instance model FormModel
        $moldModel = new DetailMold();

        // Lakukan query untuk mengambil data mold berdasarkan User_ID
        $moldData = $moldModel->where('User_ID', $userId)
            ->orderBy('Tanggal_Update', 'DESC')
            ->first();

        // Jika data mold ditemukan, ambil nama pengguna (username) dari UserModel
        $username = '';
        if ($moldData) {
            // Membuat instance model UserModel
            $userModel = new UserModel();
            // Mengambil data pengguna (username) berdasarkan User_ID dari moldData
            $user = $userModel->find($moldData['User_ID']);
            // Jika data pengguna ditemukan, simpan nama pengguna
            if ($user) {
                $username = $user['username'];
            }
        }

        // Arahkan pengguna ke view admin/usermanage.php dengan menyertakan data mold dan nama pengguna sebagai parameter
        return view('pages/admin/usermanage', ['moldData' => $moldData, 'username' => $username]);
    }

    public function getUserMold()
    {

        $user = new UserModel();
        $GetUser = $user->getUser();
        $this->response->setContentType('application/json');
        return $this->response->setJSON($GetUser);
    }


    public function getMoldByUser($userId)
    {
        // Membuat instance model MoldModel
        $moldModel = new DetailMold();

        // Mengambil data mold_cbi berdasarkan User_ID dengan urutan tanggal update desc   $moldData = $moldModel->where('User_ID', $userId)->findAll();
        $moldData = $moldModel->where('User_ID', $userId)
            ->orderBy('Tanggal_Update', 'DESC')
            ->first();;

        // Mengatur jenis konten respons menjadi JSON
        $this->response->setContentType('application/json');

        // Mengembalikan data mold dalam format JSON
        return $this->response->setJSON($moldData);
    }

    public function updateHasilVerifikasi($moldID)
    {
        // Panggil model untuk melakukan update hasil verifikasi
        $moldModel = new DetailMold();
        $data = [
            'Hasil_Verifikasi' => 1 // Ubah hasil verifikasi menjadi 1 (true)
        ];
        $result = $moldModel->update($moldID, $data);
        // Buat respons JSON
        $response = array();
        if ($result) {
            $response['success'] = true;
            $response['message'] = 'Perubahan berhasil disimpan.';
        } else {
            $response['success'] = false;
            $response['message'] = 'Gagal menyimpan perubahan.';
        }

        // Kembalikan respons sebagai JSON
        return $this->response->setJSON($response);
    }
    public function updateHasilVerifikasi2($moldID)
    {
        // Panggil model untuk melakukan update hasil verifikasi
        $moldModel = new DetailMold();
        $data = [
            'Hasil_Verifikasi' => 2 // Ubah hasil verifikasi 
        ];
        $result = $moldModel->update($moldID, $data);
        // Buat respons JSON
        $response = array();
        if ($result) {
            $response['success'] = true;
            $response['message'] = 'Perubahan berhasil disimpan.';
        } else {
            $response['success'] = false;
            $response['message'] = 'Gagal menyimpan perubahan.';
        }

        // Kembalikan respons sebagai JSON
        return $this->response->setJSON($response);
    }

    public function submit_verifikasi()
    {
        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }

        try {
            $moldModel = new DetailMold();
            $historyPerbaikan = new HistoryPerbaikanModel();
            $lampiranVisual = new LampiranVisualModel();
            $lampiranDimensi = new LampiranDimensiModel();


            // Ambil file PDF yang diunggah
            $lampiran_drawing = $this->request->getFile('drawing_produk');
            $gambar_mold = $this->request->getFile('gambar_mold');
            $gambar_part = $this->request->getFile('gambar_part');
            $gambar_runner = $this->request->getFile('gambar_runner');

            // // Validasi file PDF
            // if ($lampiran_drawing->isValid() && !$lampiran_drawing->hasMoved() && $lampiran_drawing->getExtension() === 'pdf') {
            //     // Pindahkan file PDF ke direktori yang tepat
            //     $drawingname = $lampiran_drawing->getRandomName();
            //     $lampiran_drawing->move(ROOTPATH . 'public/uploads', $drawingname);

            //     $gambarmold = $gambar_mold->getRandomName();
            //     $gambar_mold->move(ROOTPATH . 'public/uploads', $gambarmold);

            //     $gambarpart = $gambar_part->getRandomName();
            //     $gambar_part->move(ROOTPATH . 'public/uploads', $gambarpart);

            //     $gambarRunner = $gambar_runner->getRandomName();
            //     $gambar_runner->move(ROOTPATH . 'public/uploads', $gambarRunner);

            // detail_mold
            $datamold = [
                'User_ID' => $this->request->getPost('user_id'),
                'Mold_Id' => $this->request->getPost('moldIdContent'),
                'Part_Name' => $this->request->getPost('partname'),
                'Gambar_Mold' => 0,
                'Deskripsi_Mold' => $this->request->getPost('deskripsi_mold'),
                'Gambar_Part' => 0,
                'Deskripsi_Part' => $this->request->getPost('deskripsi_part'),
                'Gambar_Runner' => 0,
                'Deskripsi_Runner' => $this->request->getPost('deskripsi_runner'),
                'Tanggal_Update' => $this->request->getPost('tanggal_update'),
                'Posisi_Mold' => $this->request->getPost('posisi_mold'),
                'Drawing_Produk' => 0,
                'Subject_Mold' => $this->request->getPost('subject_mold'),
                'Subject_Tool' => $this->request->getPost('tools'),
                'Subject_Mesin' => $this->request->getPost('mesin'),
                'Subject_Produk' => $this->request->getPost('produk'),
                'Subject_Proses' => $this->request->getPost('proses'),
                'Subcount_Suplier' => $this->request->getPost('subcount'),
                'Validasi_Ke' => $this->request->getPost('verif_ke'),
                'LK3' => $this->request->getPost('lk3'),
                'Spesifikasi' => $this->request->getPost('spek'),
                'Hasil_Verifikasi' => 0
            ];

            $moldModel->save($datamold);
            $insertedId = $moldModel->getInsertID();
            //history_perbaikan
            $dataperbaikan = [
                'id_detail' => $insertedId,
                'item_perbaikan' => $this->request->getPost('item_history_perbaikan'),
                'kondisi_perbaikan' => $this->request->getPost('kondisi_history_perbaikan'),
                'rencana_perbaikan' => $this->request->getPost('rencana_perbaikan'),
                'pic_perbaikan' => $this->request->getPost('pic_history_perbaikan'),
                'tanggal_perbaikan' => $this->request->getPost('tanggal_history_perbaikan'),
                'keterangan_perbaikan' => $this->request->getPost('keterangan_history_perbaikan')

            ];
            $historyPerbaikan->save($dataperbaikan);

            //lampiran visual
            $datavisual = [
                'id_detail' => $insertedId,
                'tanggal_lampiran' => $this->request->getPost('tanggal_trial_lampiran_visual'),
                'item_lampiran' => $this->request->getPost('item_lampiran_visual'),
                'std_lampiran' => $this->request->getPost('std_lampiran_visual'),
                'actual_lampiran' => $this->request->getPost('actual_lampiran_visual'),
                'remark_lampiran' => $this->request->getPost('remark_lampiran_visual')
            ];
            $lampiranVisual->save($datavisual);
            //lampiran dimensi
            $datadimensi = [
                'id_detail' => $insertedId,
                'gambar_lampiran' => $this->request->getPost('lampiran_dimensi'),
                't3_1' => $this->request->getPost('t3-1'),
                't3_2' => $this->request->getPost('t3-2'),
                't3_3' => $this->request->getPost('t3-3'),
                't3_4' => $this->request->getPost('t3-4'),
                't3_5' => $this->request->getPost('t3-5'),
                't3_6' => $this->request->getPost('t3-6'),
                't1_1' => $this->request->getPost('t1-1'),
                't1_2' => $this->request->getPost('t1-2'),
                't1_3' => $this->request->getPost('t1-3'),
                't1_4' => $this->request->getPost('t1-4'),
                't1_5' => $this->request->getPost('t1-5'),
                't1_6' => $this->request->getPost('t1-6'),
                't2_1' => $this->request->getPost('t2-1'),
                't2_2' => $this->request->getPost('t2-2'),
                't2_3' => $this->request->getPost('t2-3'),
                't2_4' => $this->request->getPost('t2-4'),
                't2_5' => $this->request->getPost('t2-5'),
                't2_6' => $this->request->getPost('t2-6'),
            ];
            $lampiranDimensi->save($datadimensi);


                return $this->response->setJSON(['message' => 'Data submitted successfully!']);
            // } else {
            //     // File tidak valid atau bukan file PDF
            //     return $this->response->setJSON(['error' => 'Invalid or non-PDF file uploaded!']);
            // }
        } catch (\Exception $e) {
            // Tangkap dan cetak pesan kesalahan
            return $this->response->setJSON(['error' => 'Error: ' . $e->getMessage()]);
        }
    }
    public function getItemsBySupplier()
    {
        $supplierId = $this->request->getGet('supplier');

        if ($supplierId) {
            $model = new MoldItemModel();
            $items = $model->getItemBySupplier($supplierId);
            return $this->response->setJSON($items);
        }

        return $this->response->setJSON(['error' => 'ID tidak valid']);
    }
}
