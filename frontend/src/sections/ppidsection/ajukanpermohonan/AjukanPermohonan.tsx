import React, { useState } from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import api from '../../../services/api';


interface FormData {
  nik: string;
  nama: string;
  no_telepon: string;
  email: string;
  alamat: string;
  pekerjaan: string;
  cara_memperoleh_informasi: string;
  cara_mendapatkan_salinan: string;
  rincian_informasi: string;
  tujuan_penggunaan: string;
  pemohon_informasi: string;
}

const AjukanPermohonan: React.FC = () => {
  const [formData, setFormData] = useState<FormData>({
    nik: '',
    nama: '',
    no_telepon: '',
    email: '',
    alamat: '',
    pekerjaan: '',
    cara_memperoleh_informasi: '',
    cara_mendapatkan_salinan: '',
    rincian_informasi: '',
    tujuan_penggunaan: '',
    pemohon_informasi: ''
  });

  const [captcha] = useState('4618');
  const [captchaInput, setCaptchaInput] = useState('');
  const [loading, setLoading] = useState(false);
  const [success, setSuccess] = useState(false);
  const [ticketId, setTicketId] = useState('');
  const [error, setError] = useState('');

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
    const { name, value } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: value
    }));
    // Clear error saat user mulai mengetik
    if (error) setError('');
  };

  const handleCekNIK = async () => {
    if (!formData.nik) {
      setError('Masukkan NIK terlebih dahulu');
      return;
    }

    if (formData.nik.length !== 16) {
      setError('NIK harus 16 digit');
      return;
    }

    setLoading(true);
    setError('');

    try {
      // Implementasi API untuk cek NIK (jika ada endpoint-nya)
      // const response = await api.get(`/cek_nik/${formData.nik}`);
      
      // Simulasi response
      setTimeout(() => {
        setFormData(prev => ({
          ...prev,
          nama: 'John Doe',
          alamat: 'Jl. Contoh No. 123, Tangerang'
        }));
        setLoading(false);
      }, 1000);
    } catch (err: any) {
      setError('NIK tidak ditemukan atau terjadi kesalahan');
      setLoading(false);
    }
  };

  const validateForm = (): boolean => {
    if (!formData.nik || formData.nik.length !== 16) {
      setError('NIK harus diisi dengan 16 digit');
      return false;
    }

    if (!formData.nama || formData.nama.trim() === '') {
      setError('Nama harus diisi');
      return false;
    }

    if (!formData.email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.email)) {
      setError('Email harus diisi dengan format yang benar');
      return false;
    }

    if (captchaInput !== captcha) {
      setError('Captcha tidak sesuai');
      return false;
    }

    return true;
  };

   const handleSubmit = async () => {
   setError('');
   setSuccess(false);

   if (!validateForm()) return;

   setLoading(true);

   try {
     const response = await api.post('/ppid_permohonan', formData);

     if (response.data.status === 201) {
       setSuccess(true);
       setTicketId(response.data.ticket_id);
        
        // Reset form
        setFormData({
          nik: '',
          nama: '',
          no_telepon: '',
          email: '',
          alamat: '',
          pekerjaan: '',
          cara_memperoleh_informasi: '',
          cara_mendapatkan_salinan: '',
          rincian_informasi: '',
          tujuan_penggunaan: '',
          pemohon_informasi: ''
        });
        setCaptchaInput('');
        
        // Scroll ke atas untuk melihat pesan sukses
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }

      setLoading(false);
    } catch (err: any) {
      console.error('Error submitting form:', err);
      
      // ✅ PERBAIKAN: Handle error response yang lebih spesifik
      let errorMessage = 'Terjadi kesalahan saat mengirim permohonan. Silakan coba lagi.';
      
      if (err.response) {
        // Jika server memberikan response dengan error
        if (err.response.data && err.response.data.message) {
          errorMessage = err.response.data.message;
        } else if (err.response.status === 400) {
          errorMessage = 'Data yang dikirim tidak valid. Periksa kembali form Anda.';
        } else if (err.response.status === 401) {
          errorMessage = 'Anda perlu login terlebih dahulu.';
        } else if (err.response.status === 500) {
          errorMessage = 'Server sedang mengalami masalah. Silakan coba lagi nanti.';
        }
      } else if (err.request) {
        // Request dibuat tapi tidak ada response
        errorMessage = 'Tidak ada response dari server. Periksa koneksi internet Anda.';
      }
      
      setError(errorMessage);
      setLoading(false);
    }
  };

  const refreshCaptcha = () => {
    setCaptchaInput('');
    // Dalam implementasi real, bisa generate captcha baru dari server
  };

  const resetForm = () => {
    setSuccess(false);
    setTicketId('');
    setError('');
  };

  return (
    <div className="container py-5">
      <style>{`
        .form-container {
          max-width: 1200px;
          margin: 0 auto;
          background: white;
          padding: 40px;
          border-radius: 8px;
          box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-title {
          text-align: center;
          color: #2c3e50;
          font-weight: bold;
          margin-bottom: 40px;
          font-size: 28px;
        }
        .form-label {
          font-weight: 600;
          color: #2c3e50;
          margin-bottom: 8px;
          display: block;
        }
        .form-control, .form-select {
          border: 1px solid #ddd;
          padding: 10px 15px;
          border-radius: 4px;
          font-size: 14px;
          width: 100%;
        }
        .form-control:focus, .form-select:focus {
          border-color: #1976d2;
          box-shadow: 0 0 0 0.2rem rgba(25, 118, 210, 0.25);
          outline: none;
        }
        .btn-primary-custom {
          background-color: #1976d2;
          border: none;
          padding: 10px 30px;
          font-weight: 600;
          border-radius: 4px;
          transition: all 0.3s;
          color: white;
          cursor: pointer;
        }
        .btn-primary-custom:hover:not(:disabled) {
          background-color: #1565c0;
          transform: translateY(-1px);
        }
        .btn-primary-custom:disabled {
          background-color: #ccc;
          cursor: not-allowed;
          transform: none;
        }
        .btn-secondary-custom {
          background-color: #6c757d;
          border: none;
          padding: 8px 20px;
          font-weight: 600;
          border-radius: 4px;
          color: white;
          cursor: pointer;
          margin-left: 10px;
        }
        .btn-secondary-custom:hover {
          background-color: #5a6268;
        }
        .nik-section {
          display: flex;
          gap: 10px;
          align-items: flex-end;
        }
        .nik-input {
          flex: 1;
        }
        .captcha-container {
          display: flex;
          gap: 10px;
          align-items: center;
        }
        .captcha-display {
          background: #2c3e50;
          color: white;
          padding: 12px 30px;
          font-size: 24px;
          font-weight: bold;
          letter-spacing: 8px;
          border-radius: 4px;
          user-select: none;
        }
        .captcha-input {
          flex: 1;
        }
        .btn-refresh {
          background: #1976d2;
          border: none;
          color: white;
          padding: 8px 12px;
          border-radius: 4px;
          cursor: pointer;
          font-size: 18px;
        }
        .btn-refresh:hover {
          background: #1565c0;
        }
        .alert-success-custom {
          background: #d4edda;
          border: 1px solid #c3e6cb;
          color: #155724;
          padding: 20px;
          border-radius: 4px;
          margin-bottom: 20px;
        }
        .alert-danger-custom {
          background: #f8d7da;
          border: 1px solid #f5c6cb;
          color: #721c24;
          padding: 15px;
          border-radius: 4px;
          margin-bottom: 20px;
        }
        .ticket-id {
          font-size: 24px;
          font-weight: bold;
          color: #1976d2;
          margin: 10px 0;
        }
        textarea.form-control {
          min-height: 120px;
          resize: vertical;
        }
        .required::after {
          content: " *";
          color: red;
        }
      `}</style>

      <div className="form-container">
        <h1 className="form-title">Formulir Permohonan</h1>

        {success && (
          <div className="alert-success-custom">
            <h4>✓ Permohonan Berhasil Dikirim!</h4>
            <p>ID Tiket Anda:</p>
            <div className="ticket-id">{ticketId}</div>
            <p className="mb-0">Simpan ID ini untuk melacak status permohonan Anda.</p>
            <button 
              type="button" 
              className="btn-secondary-custom mt-3"
              onClick={resetForm}
            >
              Buat Permohonan Baru
            </button>
          </div>
        )}

        {error && (
          <div className="alert-danger-custom">
            <strong>✗ Error:</strong> {error}
          </div>
        )}

        <div>
          <div className="row mb-4">
            <div className="col-md-6">
              <label className="form-label required">NIK</label>
              <div className="nik-section">
                <div className="nik-input">
                  <input
                    type="text"
                    className="form-control"
                    name="nik"
                    placeholder="Masukkan Nomor NIK (16 digit)"
                    value={formData.nik}
                    onChange={handleChange}
                    maxLength={16}
                    disabled={loading}
                  />
                </div>
                <button 
                  type="button" 
                  className="btn-primary-custom"
                  onClick={handleCekNIK}
                  disabled={loading || !formData.nik}
                >
                  {loading ? 'Cek...' : 'Cek NIK'}
                </button>
              </div>
            </div>

            <div className="col-md-6">
              <label className="form-label">No Telepon</label>
              <input
                type="tel"
                className="form-control"
                name="no_telepon"
                placeholder="Masukkan nomor telepon"
                value={formData.no_telepon}
                onChange={handleChange}
                disabled={loading}
              />
            </div>
          </div>

          <div className="row mb-4">
            <div className="col-md-6">
              <label className="form-label required">Nama</label>
              <input
                type="text"
                className="form-control"
                name="nama"
                placeholder="Masukkan nama lengkap"
                value={formData.nama}
                onChange={handleChange}
                disabled={loading}
              />
            </div>

            <div className="col-md-6">
              <label className="form-label required">Email</label>
              <input
                type="email"
                className="form-control"
                name="email"
                placeholder="Masukkan email"
                value={formData.email}
                onChange={handleChange}
                disabled={loading}
              />
            </div>
          </div>

          <div className="row mb-4">
            <div className="col-md-6">
              <label className="form-label">Alamat</label>
              <input
                type="text"
                className="form-control"
                name="alamat"
                placeholder="Masukkan alamat"
                value={formData.alamat}
                onChange={handleChange}
                disabled={loading}
              />
            </div>

            <div className="col-md-6">
              <label className="form-label">Cara Memperoleh Informasi</label>
              <select
                className="form-select"
                name="cara_memperoleh_informasi"
                value={formData.cara_memperoleh_informasi}
                onChange={handleChange}
                disabled={loading}
              >
                <option value="">-- Pilih Cara --</option>
                <option value="Melihat/Membaca/Mendengarkan/Mencatat">Melihat/Membaca/Mendengarakan/Mencatat</option>
                <option value="Hardcopy">Hardcopy</option>
                <option value="Softcopy">Softcopy</option>
              </select>
            </div>
          </div>

          <div className="row mb-4">
            <div className="col-md-6">
              <label className="form-label">Pekerjaan</label>
              <input
                type="text"
                className="form-control"
                name="pekerjaan"
                placeholder="Masukkan Pekerjaan"
                value={formData.pekerjaan}
                onChange={handleChange}
                disabled={loading}
              />
            </div>

            <div className="col-md-6">
              <label className="form-label">Cara Mendapatkan Salinan Informasi</label>
              <select
                className="form-select"
                name="cara_mendapatkan_salinan"
                value={formData.cara_mendapatkan_salinan}
                onChange={handleChange}
                disabled={loading}
              >
                <option value="">-- Pilih Cara --</option>
                <option value="softcopy">Soft Copy</option>
                <option value="hardcopy">Hard Copy</option>
              </select>
            </div>
          </div>

          <div className="mb-4">
            <label className="form-label">Rincian Informasi Yang Dibutuhkan</label>
            <textarea
              className="form-control"
              name="rincian_informasi"
              placeholder="Masukkan rincian informasi yang dibutuhkan"
              value={formData.rincian_informasi}
              onChange={handleChange}
              disabled={loading}
            ></textarea>
          </div>

          <div className="mb-4">
            <label className="form-label">Tujuan Penggunaan Informasi</label>
            <textarea
              className="form-control"
              name="tujuan_penggunaan"
              placeholder="Masukkan tujuan informasi"
              value={formData.tujuan_penggunaan}
              onChange={handleChange}
              disabled={loading}
            ></textarea>
          </div>

          <div className="mb-4">
            <label className="form-label">Pemohon Informasi</label>
            <select
              className="form-select"
              name="pemohon_informasi"
              value={formData.pemohon_informasi}
              onChange={handleChange}
              disabled={loading}
            >
              <option value="">-- Pilih Pemohon Informasi --</option>
              <option value="Perorangan">Perorangan</option>
              <option value="Kelompok">Kelompok</option>
                <option value="Badan Hukum">Badan Hukum</option>
                <option value="Organisasi Berbadan Hukum">Organisasi Berbadan Hukum</option>
                <option value="Organisasi Tanpa Berbadan Hukum">Organisasi Tanpa Berbadan Hukum</option>
            </select>
          </div>

          <div className="mb-4">
            <label className="form-label required">Captcha</label>
            <div className="captcha-container">
              <input
                type="text"
                className="form-control captcha-input"
                placeholder="Masukkan captcha"
                value={captchaInput}
                onChange={(e) => setCaptchaInput(e.target.value)}
                disabled={loading}
              />
              <div className="captcha-display">{captcha}</div>
              <button 
                type="button" 
                className="btn-refresh"
                onClick={refreshCaptcha}
                title="Refresh Captcha"
                disabled={loading}
              >
                ↻
              </button>
            </div>
          </div>

          <div className="text-center mt-4">
            <button 
              type="button" 
              className="btn-primary-custom btn-lg"
              onClick={handleSubmit}
              disabled={loading}
            >
              {loading ? 'Mengirim...' : 'Kirim Permohonan'}
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};

export default AjukanPermohonan;