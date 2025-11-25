// service/api.ts (Pembaruan)
import axios from "axios";

// Definisikan tipe data untuk struktur menu dari CI4
export interface MenuItem {
  id_menu: string;
  menu_name: string;
  menu_url: string;
  menu_icon: string;
  order_number: string;
  parent_id: string;
  status: string;
  // Diperlukan: Tambahkan kolom yang menentukan komponen React yang akan di-render
  component_name?: string; 
  sub_menu?: MenuItem[];
}

export interface ApiResponse {
    status: number;
    message: string;
    data: MenuItem[];
}

const api = axios.create({
  baseURL: "http://localhost:8080/api",
  headers: {
    "Content-Type": "application/json",
  },
});

/**
 * Mengambil data menu dari API CI4
 */
export const getMenuData = async (): Promise<MenuItem[]> => {
  try {
    const response = await api.get<ApiResponse>("/menu"); // Ganti '/menu' dengan endpoint CI4 Anda
    
    // Periksa status dan kembalikan hanya array data menu
    if (response.data.status === 200) {
        return response.data.data;
    }
    throw new Error(response.data.message || "Gagal mengambil data menu.");
    
  } catch (error) {
    // Log error untuk debugging
    if (axios.isAxiosError(error)) {
        console.error("Axios Error:", error.message);
    } else {
        console.error("General Error:", error);
    }
    return []; // Kembalikan array kosong jika gagal
  }
};

export default api;