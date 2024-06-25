<x-app-layout>
  <x-slot name="header">
    {{ __('Show Data Laporan Pelanggaran') }}
  </x-slot>

  <div class="p-4 bg-white rounded-lg shadow-xs">
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
      <!-- Informasi Laporan -->
      <div>
        <p class="block text-sm font-medium text-gray-700">Nama Peserta Pemilu</p>
        <p class="block text-lg font-semibold text-gray-900">{{ $laporanPelanggaran->pelanggaran->nama_bacaleg }}</p>
      </div>
      <div>
        <p class="block text-sm font-medium text-gray-700">Jenis Pelanggaran</p>
        <p class="block text-lg font-semibold text-gray-900">
          {{ $laporanPelanggaran->pelanggaran->jenisPelanggaran->jenis_pelanggaran }}
        </p>
      </div>
      <div>
        <p class="block text-sm font-medium text-gray-700">Nama Partai</p>
        <p class="block text-lg font-semibold text-gray-900">{{ $laporanPelanggaran->pelanggaran->parpol->parpol_name }}
        </p>
      </div>
      <div>
        <p class="block text-sm font-medium text-gray-700">Provinsi</p>
        <p class="block text-lg font-semibold text-gray-900">{{ $laporanPelanggaran->province->name }}</p>
      </div>
      <div>
        <p class="block text-sm font-medium text-gray-700">Kabupaten/Kota</p>
        <p class="block text-lg font-semibold text-gray-900">{{ $laporanPelanggaran->regency->name }}</p>
      </div>
      <div>
        <p class="block text-sm font-medium text-gray-700">Kecamatan</p>
        <p class="block text-lg font-semibold text-gray-900">{{ $laporanPelanggaran->district->name }}</p>
      </div>
      <div>
        <p class="block text-sm font-medium text-gray-700">Kelurahan/Desa</p>
        <p class="block text-lg font-semibold text-gray-900">{{ $laporanPelanggaran->village->name }}</p>
      </div>
      <div class="col-span-2">
        <p class="block text-sm font-medium text-gray-700">Alamat Pelanggaran</p>
        <p class="block text-lg font-semibold text-gray-900">{{ $laporanPelanggaran->address }}</p>
      </div>
      <div class="col-span-2">
        <p class="block text-sm font-medium text-gray-700">Keterangan</p>
        <p class="block text-lg font-semibold text-gray-900">{{ $laporanPelanggaran->pelanggaran->keterangan }}</p>
      </div>

      <!-- Bukti Pelanggaran -->
      <div class="col-span-2">
        <p class="block text-sm font-medium text-gray-700">Bukti Pelanggaran</p>
        <div class="grid grid-cols-3 gap-3 mt-2">
          @foreach ($laporanPelanggaran->pelanggaran->pelanggaranImages as $image)
            <div class="relative">
              <img src="{{ asset('storage/pelanggarans/' . $image->image) }}" alt="{{ $image->image }}"
                class="h-50 w-50 object-cover rounded-lg">
            </div>
          @endforeach
        </div>
      </div>
    </div>

    <!-- Map Section -->
    <div class="col-span-2 mt-6">
      <p class="block text-sm font-medium text-gray-700">Lokasi Pelanggaran</p>
      <div id="map" style="height: 400px;" class="mt-2"></div>
    </div>

    <!-- Tombol Kembali -->
    <div class="flex justify-end mt-4">
      <a href="{{ route('laporanpelanggarans.index') }}"
        class="px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 bg-white border border-gray-300 rounded-lg active:bg-gray-100 hover:bg-gray-200 focus:outline-none focus:shadow-outline-gray">
        Kembali
      </a>
    </div>

  </div>

  <!-- Include Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

  <!-- Include Leaflet JavaScript -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

  <!-- Initialize Leaflet Map -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var map = L.map('map').setView([{{ $laporanPelanggaran->latitude }}, {{ $laporanPelanggaran->longitude }}],
        13);

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
      }).addTo(map);

      var marker = L.marker([{{ $laporanPelanggaran->latitude }}, {{ $laporanPelanggaran->longitude }}]).addTo(map);
    });
  </script>
</x-app-layout>
