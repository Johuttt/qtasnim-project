<?php

namespace App\Controllers;

use App\Models\DetailMold;
use App\Models\HistoryPerbaikanModel;
use App\Models\LampiranDimensiModel;
use App\Models\LampiranVisualModel;
use App\Models\MoldItemModel;
use App\Models\UserModel;
use App\Models\AkumulasiShortModel;
use App\Models\short_akumulasiModel;

class User extends BaseController
{
    public function perbaikan()
    {
        if (session()->get('user_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        return view('pages/user/perbaikan');
    }
    public function reject()
    {
        if (session()->get('user_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        return view('pages/user/reject');
    }

    public function Form()
    {
        if (session()->get('user_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }

        $moldItemModel = new MoldItemModel();

        // Mengambil semua item dari model
        $items = $moldItemModel->getAllItems();

        // Meneruskan data ke tampilan
        $data['items'] = $items;

        return view('pages/user/form', $data);
    }

    public function dashboard()
    {
        if (session()->get('user_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        return view('pages/user/dashboard');
    }

    public function short()
    {
        if (session()->get('user_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        return view('pages/user/user_short');
    }

    public function formUpdate()
    {
        if (session()->get('user_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }

        // $detail = new DetailMold();

        // // Mengambil semua item dari model
        // $items['data'] = $detail->getitemUser($userId);

        return view('pages/user/form_update');
    }


    // public function submit_short()
    // {
    //     if (session()->get('user_nama') == '') {
    //         session()->setFlashdata('gagal', 'Anda belum login');
    //         return redirect()->to(base_url('/'));
    //     }

    //     try {
    //         $shortModel = new AkumulasiShortModel();
    //         $detailMoldModel = new DetailMold();
    //         $userID = session()->get('user_id');

    //         // Get the most recent id_detail from detail_mold for the current user
    //         $latestDetailMold = $detailMoldModel
    //             ->where('User_ID', $userID)
    //             ->orderBy('tanggal_update', 'DESC')
    //             ->first();

    //         if ($latestDetailMold) {
    //             $idDetail = $latestDetailMold['Id'];

    //             // Check if part_name matches the one in detail_mold
    //             $partName = $this->request->getPost('part_name');
    //             if ($partName !== $latestDetailMold['Part_Name']) {
    //                 return $this->response->setJSON(['error' => 'Part name does not match the latest detail mold.']);
    //             }

    //             // Get form data
    //             $data = [
    //                 'User_ID' => $userID,
    //                 'id_detail' => $idDetail,
    //                 'part_name' => $partName,
    //                 'suplier' => $this->request->getPost('suplier'),
    //                 'tanggal_update' => $this->request->getPost('tanggal_update'),
    //                 'bulan' => $this->request->getPost('bulan'),
    //                 'kapasitas' => $this->request->getPost('kapasitas'),
    //                 'jml_short_perbulan' => $this->request->getPost('jml_short_perbulan'),
    //                 'akumulasi' => $this->request->getPost('akumulasi'),
    //                 'persentase_loading' => $this->request->getPost('persentase_loading'),
    //                 'persentase_satujuta' => $this->request->getPost('persentase_satujuta'),
    //                 'keterangan' => $this->request->getPost('keterangan')
    //             ];

    //             $shortModel->save($data);

    //             return $this->response->setJSON(['message' => 'Data submitted successfully!']);
    //         } else {
    //             return $this->response->setJSON(['error' => 'No detail mold found for the current user.']);
    //         }
    //     } catch (\Exception $e) {
    //         // Capture and return the error message
    //         return $this->response->setJSON(['error' => 'Error: ' . $e->getMessage()]);
    //     }
    // }


    // public function submit()
    // {
    //     $lampiranDimensiModel = new LampiranDimensiModel();

    //     // Debugging statement
    //     $datadimensi = [
    //         'id_detail' => 2,
    //         'gambar_lampiran' => 'sasas',
    //         't1_1' => $this->request->getPost('t1_1'),
    //         't1_2' => $this->request->getPost('t1_2'),
    //         't1_3' => $this->request->getPost('t1_3'),
    //         't1_4' => $this->request->getPost('t1_4'),
    //         't1_5' => $this->request->getPost('t1_5'),
    //         't1_6' => $this->request->getPost('t1_6'),
    //         't2_1' => $this->request->getPost('t2_1'),
    //         't2_2' => $this->request->getPost('t2_2'),
    //         't2_3' => $this->request->getPost('t2_3'),
    //         't2_4' => $this->request->getPost('t2_4'),
    //         't2_5' => $this->request->getPost('t2_5'),
    //         't2_6' => $this->request->getPost('t2_6'),
    //         't0_1' => $this->request->getPost('t3_1'),
    //         't0_2' => $this->request->getPost('t3_2'),
    //         't0_3' => $this->request->getPost('t3_3'),
    //         't0_4' => $this->request->getPost('t3_4'),
    //         't0_5' => $this->request->getPost('t3_5'),
    //         't0_6' => $this->request->getPost('t3_6')
    //     ];

    //     // Debugging statement
    //     var_dump($datadimensi);

    //     $lampiranDimensiModel->save($datadimensi);

    //     return $this->response->setJSON(['message' => 'Data submitted successfully!']);
    // }


    public function submitForm_rev()
    {
        if (session()->get('user_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }

        try {
            $moldModel = new DetailMold();
            $historyPerbaikan = new HistoryPerbaikanModel();
            $lampiranVisual = new LampiranVisualModel();
            $lampiranDimensi = new LampiranDimensiModel();

            $userID = session()->get('user_id');

            // Ambil file PDF yang diunggah
            $lampiran_drawing = $this->request->getFile('drawing_produk');
            $gambar_mold = $this->request->getFile('gambar_mold');
            $gambar_part = $this->request->getFile('gambar_part');
            $gambar_runner = $this->request->getFile('gambar_runner');

            // Validasi file PDF
            if ($lampiran_drawing->isValid() && !$lampiran_drawing->hasMoved() && $lampiran_drawing->getExtension() === 'pdf') {
                // Pindahkan file PDF ke direktori yang tepat
                $drawingname = $lampiran_drawing->getRandomName();
                $lampiran_drawing->move(ROOTPATH . 'public/uploads', $drawingname);

                $gambarmold = $gambar_mold->getRandomName();
                $gambar_mold->move(ROOTPATH . 'public/uploads', $gambarmold);

                $gambarpart = $gambar_part->getRandomName();
                $gambar_part->move(ROOTPATH . 'public/uploads', $gambarpart);

                $gambarRunner = $gambar_runner->getRandomName();
                $gambar_runner->move(ROOTPATH . 'public/uploads', $gambarRunner);

                // detail_mold
                $datamold = [
                    'User_ID' => $userID,
                    'Mold_Id' => $this->request->getPost('moldIdContent'),
                    'Part_Name' => $this->request->getPost('partname'),
                    'Gambar_Mold' => $gambarmold,
                    'Deskripsi_Mold' => $this->request->getPost('deskripsi_mold'),
                    'Gambar_Part' => $gambarpart,
                    'Deskripsi_Part' => $this->request->getPost('deskripsi_part'),
                    'Gambar_Runner' => $gambarRunner,
                    'Deskripsi_Runner' => $this->request->getPost('deskripsi_runner'),
                    'Tanggal_Update' => $this->request->getPost('tanggal_update'),
                    'Posisi_Mold' => $this->request->getPost('posisi_mold'),
                    'Drawing_Produk' => $drawingname,
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
                    't0_1' => $this->request->getPost('t3-1'),
                    't0_2' => $this->request->getPost('t3-2'),
                    't0_3' => $this->request->getPost('t3-3'),
                    't0_4' => $this->request->getPost('t3-4'),
                    't0_5' => $this->request->getPost('t3-5'),
                    't0_6' => $this->request->getPost('t3-6'),
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
            } else {
                // File tidak valid atau bukan file PDF
                return $this->response->setJSON(['error' => 'Invalid or non-PDF file uploaded!']);
            }
        } catch (\Exception $e) {
            // Tangkap dan cetak pesan kesalahan
            return $this->response->setJSON(['error' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function updateData()
    {
        if (session()->get('user_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }

        try {
            $moldModel = new DetailMold();
            $lampiranVisual = new LampiranVisualModel();
            $lampiranDimensi = new LampiranDimensiModel();
            $historyPerbaikan = new HistoryPerbaikanModel();
            $userID = session()->get('user_id');

            $data = $this->request->getPost(); // Get data from POST request

            $existingData = $moldModel->find($data['Id']);
            if (!$existingData) {
                return $this->response->setJSON(['error' => 'Data not found!']);
            }

            // Validate required fields
            if (!isset($data['Id'])) {
                return $this->response->setJSON(['error' => 'Part Name and Tanggal Update are required!']);
            }

            // Upload new files and delete existing ones
            $drawingname = $this->uploadFile('drawing_produk');
            $gambarmold = $this->uploadFile('gambar_mold');
            $gambarpart = $this->uploadFile('gambar_part');
            $gambarRunner = $this->uploadFile('gambar_runner');

            // Prepare data for update
            $updateData_detail = [
                'User_ID' => $userID,
                'Part_Name' => $data['partname'],
                'Gambar_Mold' => $gambarmold,
                'Deskripsi_Mold' => $data['deskripsi_mold'],
                'Gambar_Part' => $gambarpart,
                'Deskripsi_Part' => $data['deskripsi_part'],
                'Gambar_Runner' => $gambarRunner,
                'Deskripsi_Runner' => $data['deskripsi_runner'],
                'Tanggal_Update' => $data['tanggal_update'],
                'Posisi_Mold' => $data['posisi_mold'],
                'Drawing_Produk' => $drawingname,
                'Subject_Mold' => $data['subject_mold'],
                'Subject_Tool' => $data['tools'],
                'Subject_Mesin' => $data['mesin'],
                'Subject_Produk' => $data['produk'],
                'Subject_Proses' => $data['proses'],
                'Subcount_Suplier' => $data['subcount'],
                'Validasi_Ke' => $data['verif_ke'],
                'LK3' => $data['lk3'],
                'Spesifikasi' => $data['spek'],
                'Hasil_Verifikasi' => $data['hasilverif']
            ];

            $updateData_Ldimensi = [
                'gambar_lampiran' => $data['gambar_lampiran'],
                't1_1' => $data['t1_1'],
                't1_2' => $data['t1_2'],
                't1_3' => $data['t1_3'],
                't1_4' => $data['t1_4'],
                't1_5' => $data['t1_5'],
                't1_6' => $data['t1_6'],
                't2_1' => $data['t2_1'],
                't2_2' => $data['t2_2'],
                't2_3' => $data['t2_3'],
                't2_4' => $data['t2_4'],
                't2_5' => $data['t2_5'],
                't2_6' => $data['t2_6'],
                't3_1' => $data['t3_1'],
                't3_2' => $data['t3_2'],
                't3_3' => $data['t3_3'],
                't3_4' => $data['t3_4'],
                't3_5' => $data['t3_5'],
                't3_6' => $data['t3_6']
            ];

            $updateData_Lvisual = [
                'tanggal_lampiran' => $data['tanggal_trial_lampiran_visual'],
                'item_lampiran' => $data['item_lampiran_visual'],
                'std_lampiran' => $data['std_lampiran_visual'],
                'actual_lampiran' => $data['actual_lampiran_visual'],
                'remark_lampiran' => $data['remark_lampiran_visual']
            ];

            $update_Hperbaikan = [
                'item_perbaikan' => $data['item_history_perbaikan'],
                'kondisi_perbaikan' => $data['kondisi_history_perbaikan'],
                'rencana_perbaikan' => $data['rencana_perbaikan'],
                'pic_perbaikan' => $data['pic_history_perbaikan'],
                'tanggal_perbaikan' => $data['tanggal_history_perbaikan'],
                'keterangan_perbaikan' => $data['keterangan_history_perbaikan']
            ];

            // Update data in the database
            $moldModel->update($data['Id'], $updateData_detail);
            $lampiranDimensi->update($data['id_lampiran'], $updateData_Ldimensi);
            $lampiranVisual->update($data['id_lampiran_visual'], $updateData_Lvisual);
            $historyPerbaikan->update($data['id_perbaikan'], $update_Hperbaikan);

            return $this->response->setJSON(['message' => 'Data berhasil diupdate!']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Error: ' . $e->getMessage()]);
        }
    }

    private function uploadFile($fieldName)
    {
        $file = $this->request->getFile($fieldName);
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads', $newName);
            return $newName;
        }
        return null;
    }

    public function getUserData()
    {
        // Periksa apakah pengguna telah login
        if (!session()->has('user_nama')) {
            // Jika pengguna belum login, arahkan ke halaman login
            session()->setFlashdata('error', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }

        // Dapatkan User_ID pengguna dari sesi
        $userId = session()->get('user_id');

        // Instansiasi model UserModel
        $formModel = new UserModel();
        $detail = new DetailMold();
        // Panggil fungsi dari model untuk mendapatkan data berdasarkan User_ID
        $userData['data_user'] = $formModel->getUserByUsername($userId);
        $userData['By_id'] = $detail->getDataByUserId($userId);

        // Periksa apakah data ditemukan
        if ($userData) {
            // Kembalikan data sebagai JSON
            $this->response->setContentType('application/json');
            return $this->response->setJSON($userData);
        } else {
            // Kembalikan pesan error jika data tidak ditemukan
            return $this->response->setJSON(['error' => 'Data tidak ditemukan untuk User_ID yang diberikan.']);
        }
    }

   

    public function getDataUpdate()
    {
        if (session()->get('user_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }

        // Dapatkan User_ID pengguna dari sesi
        $userId = session()->get('user_id');
        $detail = new DetailMold();
        $moldItemModel = new MoldItemModel();

        $items['data_item'] = $moldItemModel->getAllItems();
        $items['data_user'] = $detail->getitemUser($userId);

        if ($items) {
            // Kembalikan data sebagai JSON
            $this->response->setContentType('application/json');
            return $this->response->setJSON($items);
        } else {
            // Kembalikan pesan error jika data tidak ditemukan
            return $this->response->setJSON(['error' => 'Data tidak ditemukan untuk User_ID yang diberikan.']);
        }
    }


    //ambil data mold apa saja yang ada di satu suplier
    public function getItemBySupplier()
    {
        $usermodel = new usermodel();
        $UserID = session()->get('user_id');
        $latestDetailMold = $usermodel
            ->where('id', $UserID)
            ->first();

        $supplier = $latestDetailMold['suplier'];
        // Membuat instance model MoldItemModel
        $moldItemModel = new MoldItemModel();

        // Memanggil method untuk mengambil data ITEM berdasarkan SUPPLIER
        $items = $moldItemModel->getItemBySupplier($supplier);

        $this->response->setContentType('application/json');
        return $this->response->setJSON($items);
    }

    public function submit_shortREV()
    {
        if (session()->get('user_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }

        try {
            $akumulasi = new short_akumulasiModel();
            $userID = session()->get('user_id');

            // Get form data
            $data = [
                'user_id' => $userID,
                'id_mold' => $this->request->getPost('moldId'),
                'nama_mold' => $this->request->getPost('part_name'),
                'suplier' => $this->request->getPost('suplier'),
                'tanggal_update' => $this->request->getPost('tanggal_update'),
                'bulan' => $this->request->getPost('bulan'),
                'kapasitas' => $this->request->getPost('kapasitas'),
                'jml_short_perbulan' => $this->request->getPost('jml_short_perbulan'),
                'akumulasi' => $this->request->getPost('akumulasi'),
                'persentase_loading' => $this->request->getPost('persentase_loading'),
                'persentase_satujuta' => $this->request->getPost('persentase_satujuta')
            ];

            $akumulasi->save($data);
            return $this->response->setJSON(['message' => 'Data submitted successfully!']);
        } catch (\Exception $e) {
            // Capture and return the error message
            return $this->response->setJSON(['error' => 'Error: ' . $e->getMessage()]);
        }
    }
}
