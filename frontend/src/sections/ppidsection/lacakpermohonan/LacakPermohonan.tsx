import React, { useState } from 'react';
import api from '../../../services/api';

// --- Definisi Interface (Bisa ditaruh di file terpisah) ---
interface PermohonanData {
  id_formulir: string;
  nama: string;
  status: string;
  tanggal_permohonan: string;
  tanggal_diproses: string | null;
}

interface ApiResponse {
  status: number;
  message: string;
  data: PermohonanData;
  messages?: {
    error?: string;
  };
}

const CheckStatus: React.FC = () => {
  // State Input: string karena input HTML selalu string
  const [ticketId, setTicketId] = useState<string>('');
  
  // State Data: Bisa null jika belum ada data, atau object PermohonanData
  const [result, setResult] = useState<PermohonanData | null>(null);
  
  // State UI
  const [loading, setLoading] = useState<boolean>(false);
  const [error, setError] = useState<string>('');

  const handleCheck = async (e: React.FormEvent) => {
    e.preventDefault();

    setLoading(true);
    setError('');
    setResult(null);

    if (!ticketId) {
      setError('Mohon isi ID Formulir terlebih dahulu.');
      setLoading(false);
      return;
    }

    try {
      // Pastikan VITE_API_URL di .env isinya: http://localhost:8080
      // Dan tambahkan /api/ di URL path
      const response = await fetch(`${import.meta.env.VITE_API_URL}/api/ppid_permohonan/status/${ticketId}`);
      // Casting result json
      const json = (await response.json()) as ApiResponse;

      if (response.ok) {
        setResult(json.data);
      } else {
        const errorMsg = json.messages?.error || json.message || 'Data tidak ditemukan';
        setError(errorMsg);
      }
    } catch (err) {
      console.error(err);
      setError('Gagal menghubungi server. Pastikan API berjalan.');
    }
  };

  // Helper function untuk warna status (Type safe)
  const getStatusColor = (status: string): string => {
    switch (status.toLowerCase()) {
      case 'pending': return '#ffc107'; // Kuning
      case 'diproses': return '#17a2b8'; // Biru
      case 'selesai': return '#28a745'; // Hijau
      case 'ditolak': return '#dc3545'; // Merah
      default: return '#6c757d'; // Abu-abu
    }
  };

  return (
    <div style={styles.container}>
      <h2>Cek Status Permohonan</h2>
      
      <form onSubmit={handleCheck} style={styles.form}>
        <input
          type="number"
          placeholder="Masukkan ID Tiket (8 digit)"
          value={ticketId}
          onChange={(e) => setTicketId(e.target.value)}
          style={styles.input}
        />
        <button type="submit" disabled={loading} style={styles.button}>
          {loading ? 'Memuat...' : 'Cek Status'}
        </button>
      </form>

      {error && <div style={styles.error}>{error}</div>}

      {/* Render Data jika result tidak null */}
      {result && (
        <div style={styles.resultCard}>
          <h3 style={{ color: 'green', marginTop: 0 }}>Data Ditemukan ✅</h3>
          <table style={styles.table}>
            <tbody>
              <tr>
                <td style={styles.tdLabel}>ID Formulir</td>
                <td>: <strong>{result.id_formulir}</strong></td>
              </tr>
              <tr>
                <td style={styles.tdLabel}>Nama</td>
                <td>: {result.nama}</td>
              </tr>
              <tr>
                <td style={styles.tdLabel}>Status</td>
                <td>: 
                  <span style={{
                    ...styles.badge,
                    backgroundColor: getStatusColor(result.status)
                  }}>
                    {result.status.toUpperCase()}
                  </span>
                </td>
              </tr>
              <tr>
                <td style={styles.tdLabel}>Tgl Permohonan</td>
                <td>: {result.tanggal_permohonan}</td>
              </tr>
              {result.tanggal_diproses && (
                <tr>
                  <td style={styles.tdLabel}>Tgl Diproses</td>
                  <td>: {result.tanggal_diproses}</td>
                </tr>
              )}
            </tbody>
          </table>
        </div>
      )}
    </div>
  );
};

// --- Styles Object (Typed as React.CSSProperties) ---
const styles: { [key: string]: React.CSSProperties } = {
  container: {
    maxWidth: '500px',
    margin: '50px auto',
    padding: '24px',
    border: '1px solid #e0e0e0',
    borderRadius: '12px',
    fontFamily: '"Inter", sans-serif',
    boxShadow: '0 4px 12px rgba(0,0,0,0.05)'
  },
  form: {
    display: 'flex',
    gap: '10px',
    marginBottom: '20px'
  },
  input: {
    flex: 1,
    padding: '12px',
    borderRadius: '6px',
    border: '1px solid #ccc',
    fontSize: '16px'
  },
  button: {
    padding: '12px 24px',
    backgroundColor: '#007BFF',
    color: 'white',
    border: 'none',
    borderRadius: '6px',
    cursor: 'pointer',
    fontWeight: 600
  },
  error: {
    padding: '12px',
    backgroundColor: '#ffe6e6',
    color: '#d63031',
    borderRadius: '6px',
    marginBottom: '20px',
    fontSize: '14px'
  },
  resultCard: {
    padding: '20px',
    backgroundColor: '#f8f9fa',
    borderRadius: '8px',
    border: '1px solid #e9ecef'
  },
  table: {
    width: '100%',
    borderCollapse: 'collapse',
  },
  tdLabel: {
    width: '140px',
    color: '#555',
    padding: '8px 0'
  },
  badge: {
    color: '#fff',
    padding: '4px 10px',
    borderRadius: '20px',
    fontSize: '0.85em',
    fontWeight: 'bold',
    marginLeft: '5px',
    display: 'inline-block'
  }
};

export default CheckStatus;