<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Merek;
use App\Models\Produk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nonaktifkan foreign key checks sementara untuk refresh data bersih
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Produk::truncate();
        Kategori::truncate();
        Merek::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Kategori
        $kategoriList = [
            'Semen & Mortar',
            'Besi & Baja Tulangan',
            'Cat & Pelapis Anti Bocor',
            'Keramik & Granit',
            'Atap & Kayu Konstruksi',
            'Pipa & Perlengkapan Sanitari',
            'Pagar & Teralis',
        ];

        $kategoris = [];
        foreach ($kategoriList as $nama) {
            $kategoris[$nama] = Kategori::create(['nama' => $nama]);
        }

        // 2. Merek
        $merekList = [
            'Semen Tiga Roda',
            'Semen Gresik',
            'Krakatau Steel',
            'Avian Brands',
            'Dulux',
            'Roman Ceramics',
            'Rucika',
            'Toto',
        ];

        $mereks = [];
        foreach ($merekList as $nama) {
            $mereks[$nama] = Merek::create(['nama' => $nama]);
        }

        // 3. Produk dengan gambar riil & relevan (Unsplash)
        $produks = [
            [
                'nama' => 'Semen Portland Komposit Tiga Roda 50 Kg',
                'kategori' => 'Semen & Mortar',
                'merek' => 'Semen Tiga Roda',
                'satuan' => 'Zak',
                'harga' => 69000,
                'status_stok' => true,
                'deskripsi' => 'Semen serbaguna bermutu tinggi dengan kuat tekan stabil. Sangat cocok untuk konstruksi beton bertulang, pasangan bata merah, plesteran dinding, dan pembuatan batako.',
                'gambar' => 'https://images.unsplash.com/photo-1589939705384-5185137a7f0f?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'nama' => 'Semen Gresik PPC 40 Kg',
                'kategori' => 'Semen & Mortar',
                'merek' => 'Semen Gresik',
                'satuan' => 'Zak',
                'harga' => 56500,
                'status_stok' => true,
                'deskripsi' => 'Semen ramah lingkungan dengan butiran halus, menghasilkan acian yang halus, rapat, dan tidak mudah retak rambut. Ideal untuk pengerjaan dinding rumah tinggal.',
                'gambar' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'nama' => 'Semen Mortar Instan Pasang Bata Ringan 40 Kg',
                'kategori' => 'Semen & Mortar',
                'merek' => 'Semen Tiga Roda',
                'satuan' => 'Zak',
                'harga' => 78000,
                'status_stok' => true,
                'deskripsi' => 'Semen instan siap pakai khusus perekat bata ringan (hebel). Cukup ditambah air, memiliki daya rekat ekstra kuat dengan ketebalan spesi hanya 2-3 mm.',
                'gambar' => 'https://images.unsplash.com/photo-1590381105924-c72589b9ef3f?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'nama' => 'Besi Beton Ulir D12 SNI Full (Panjang 12m)',
                'kategori' => 'Besi & Baja Tulangan',
                'merek' => 'Krakatau Steel',
                'satuan' => 'Batang',
                'harga' => 118000,
                'status_stok' => true,
                'deskripsi' => 'Besi beton ulir standar SNI BjTS 420B resmi dari pabrikan Krakatau Steel. Diameter presisi penuh untuk struktur tiang kolom, sloof, dan pondasi cakar ayam rumah bertingkat.',
                'gambar' => 'https://images.unsplash.com/photo-1504917599217-d4dc5ebe6122?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'nama' => 'Besi Beton Polos 10mm SNI (Panjang 12m)',
                'kategori' => 'Besi & Baja Tulangan',
                'merek' => 'Krakatau Steel',
                'satuan' => 'Batang',
                'harga' => 79000,
                'status_stok' => true,
                'deskripsi' => 'Besi tulangan polos SNI dengan kelenturan optimal dan daya tahan korosi baik. Sangat cocok untuk begel (sengkang) dan penguat cor plat lantai dak.',
                'gambar' => 'https://images.unsplash.com/photo-1535813547-99c456a41d4a?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'nama' => 'Baja Ringan C-Truss 75 Tebal 0.75mm (Panjang 6m)',
                'kategori' => 'Besi & Baja Tulangan',
                'merek' => 'Krakatau Steel',
                'satuan' => 'Batang',
                'harga' => 92000,
                'status_stok' => true,
                'deskripsi' => 'Rangka atap baja ringan profil C berlapis Zincalume tahan karat seumur hidup. Ringan, kokoh, dan anti rayap untuk konstruksi atap modern.',
                'gambar' => 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'nama' => 'Cat Tembok Interior Avitex Putih Super 25 Kg (Pail)',
                'kategori' => 'Cat & Pelapis Anti Bocor',
                'merek' => 'Avian Brands',
                'satuan' => 'Pail',
                'harga' => 335000,
                'status_stok' => true,
                'deskripsi' => 'Cat tembok favorit keluarga Indonesia dengan resin berkualitas tinggi. Menutup noda dengan sempurna, cepat kering, tanpa merkuri dan timbal aman untuk keluarga.',
                'gambar' => 'https://images.unsplash.com/photo-1562259949-e8e7689d7828?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'nama' => 'Pelapis Anti Bocor Aquaproof Abu-Abu 4 Kg',
                'kategori' => 'Cat & Pelapis Anti Bocor',
                'merek' => 'Avian Brands',
                'satuan' => 'Galon',
                'harga' => 220000,
                'status_stok' => true,
                'deskripsi' => 'Cat pelapis anti bocor thixotropic berbahan dasar polimer sintetis. Sangat elastis, kedap air, tahan cuaca panas hujan dan menutupi retak rambut dinding eksterior.',
                'gambar' => 'https://images.unsplash.com/photo-1589939705384-5185137a7f0f?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'nama' => 'Cat Eksterior Dulux Weathershield 20 Liter',
                'kategori' => 'Cat & Pelapis Anti Bocor',
                'merek' => 'Dulux',
                'satuan' => 'Pail',
                'harga' => 1480000,
                'status_stok' => false,
                'deskripsi' => 'Cat dinding luar premium dengan teknologi Smart Release yang melindungi tembok rumah dari jamur dan lumut 2x lebih lama di iklim tropis.',
                'gambar' => 'https://images.unsplash.com/photo-1595428774223-ef52624120d2?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'nama' => 'Keramik Lantai Roman dCastello Grey Matt 40x40',
                'kategori' => 'Keramik & Granit',
                'merek' => 'Roman Ceramics',
                'satuan' => 'Dus',
                'harga' => 87000,
                'status_stok' => true,
                'deskripsi' => 'Keramik lantai bertekstur matt kesat anti selip. Pilihan paling aman untuk lansia pada area kamar mandi kering, teras depan, garasi, dan dapur (1 dus isi 6 keping = 0.96 m²).',
                'gambar' => 'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'nama' => 'Granit Roman Granit 60x60 Glazed Polished Travertine',
                'kategori' => 'Keramik & Granit',
                'merek' => 'Roman Ceramics',
                'satuan' => 'Dus',
                'harga' => 210000,
                'status_stok' => true,
                'deskripsi' => 'Granit lantai kilap mewah dengan tepian presisi cutting lurus (rectified). Memberikan kesan lapang, elegan, dan mewah untuk ruang tamu dan ruang keluarga.',
                'gambar' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'nama' => 'Balok Kayu Meranti Oven 6x12x4 Meter',
                'kategori' => 'Atap & Kayu Konstruksi',
                'merek' => 'Krakatau Steel',
                'satuan' => 'Batang',
                'harga' => 185000,
                'status_stok' => true,
                'deskripsi' => 'Kayu meranti solid kelas kuat II hasil proses oven kering. Lurus, minim susut muai, bebas rayap dan siap pasang untuk usuk, reng, atau kusen pintu.',
                'gambar' => 'https://images.unsplash.com/photo-1538688525198-9b88f6f53126?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'nama' => 'Pipa PVC Rucika D 3 Inch (Panjang 4 Meter)',
                'kategori' => 'Pipa & Perlengkapan Sanitari',
                'merek' => 'Rucika',
                'satuan' => 'Batang',
                'harga' => 108000,
                'status_stok' => true,
                'deskripsi' => 'Pipa saluran air buangan limbah rumah tangga berkualitas JIS standar. Tahan tekanan, elastisitas tinggi dan tidak gampang pecah saat tertimbun tanah.',
                'gambar' => 'https://images.unsplash.com/photo-1607400201889-565b1dd75f8e?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'nama' => 'Kloset Duduk Toto Eco Washer Komplit Putih',
                'kategori' => 'Pipa & Perlengkapan Sanitari',
                'merek' => 'Toto',
                'satuan' => 'Set',
                'harga' => 2490000,
                'status_stok' => true,
                'deskripsi' => 'Kloset duduk ergonomis standar rumah sakit dan hotel berbintang. Ketinggian duduk sangat nyaman bagi orang tua dan lansia, dilengkapi bidet bilas semprot higienis.',
                'gambar' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=800&q=80',
            ],
        ];

        foreach ($produks as $item) {
            Produk::create([
                'nama' => $item['nama'],
                'kategori_id' => $kategoris[$item['kategori']]->id,
                'merek_id' => $mereks[$item['merek']]->id,
                'satuan' => $item['satuan'],
                'harga' => $item['harga'],
                'status_stok' => $item['status_stok'],
                'deskripsi' => $item['deskripsi'],
                'gambar' => $item['gambar'],
            ]);
        }
    }
}
