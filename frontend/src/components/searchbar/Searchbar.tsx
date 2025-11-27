import { Search } from "lucide-react";
import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import './Searchbar.css';

const Searchbar: React.FC = () => {
    const [searchQuery, setSearchQuery] = useState("");
    const navigate = useNavigate();

    const handleSearch = (e: React.FormEvent) => {
        e.preventDefault();
        if (searchQuery.trim()) {
            navigate(`/berita?search=${encodeURIComponent(searchQuery.trim())}`);
        }
    };

    const handleKeyPress = (e: React.KeyboardEvent) => {
        if (e.key === 'Enter') {
            handleSearch(e);
        }
    };

    return(
        <>
            <div className="search-wrapper d-flex align-items-center">
                <div className="search-input-wrapper">
                    <input
                        type="text"
                        placeholder="Apa yang kamu cari"
                        className="search-input"
                        value={searchQuery}
                        onChange={(e) => setSearchQuery(e.target.value)}
                        onKeyPress={handleKeyPress}
                    />
                </div>
                <button className="btn-search" onClick={handleSearch}>
                    <Search className="icon-search" />
                </button>
            </div> 
        </>
    )
}

export default Searchbar;