<x-app-layout>
  <x-slot name="header">
    {{ __('Laporan Pelanggaran') }}
  </x-slot>

  <div class="p-4 bg-white rounded-lg shadow-xs">
    <!-- Alert section -->
    @if (session('success'))
      <div id="alert-success" class="inline-flex overflow-hidden mb-4 w-full bg-white rounded-lg shadow-md">
        <div class="flex justify-center items-center w-12 bg-blue-500">
          <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z">
            </path>
          </svg>
        </div>
        <div class="px-4 py-2 -mx-3">
          <div class="mx-3">
            <span class="font-semibold text-blue-500">Success</span>
            <p class="text-sm text-gray-600">{{ session('success') }}</p>
          </div>
        </div>
      </div>
    @elseif(session('error'))
      <div id="alert-error" class="inline-flex overflow-hidden mb-4 w-full bg-white rounded-lg shadow-md">
        <div class="flex justify-center items-center w-12 bg-red-500">
          <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z">
            </path>
          </svg>
        </div>
        <div class="px-4 py-2 -mx-3">
          <div class="mx-3">
            <span class="font-semibold text-red-500">Error</span>
            <p class="text-sm text-gray-600">{{ session('error') }}</p>
          </div>
        </div>
      </div>
    @endif
    <!-- End of alert section -->

    <div class="flex justify-end mb-4">
      <a href="{{ route('laporanpelanggarans.create') }}"
        class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
        Tambah Laporan Pelanggaran
      </a>
    </div>

    <div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
      <div class="overflow-x-auto w-full">
        <table class="w-full whitespace-no-wrap">
          <thead>
            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 border-b">
              <th class="px-4 py-3">Nama Peserta Pemilu</th>
              <th class="px-4 py-3">Jenis Pelanggaran</th>
              <th class="px-4 py-3">Nama Partai</th>
              <th class="px-4 py-3">Status</th>
              <th class="px-4 py-3">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($laporanPelanggarans as $laporan)
              <tr class="text-gray-700">
                <td class="px-4 py-3 text-sm">
                  {{ $laporan->pelanggaran->nama_bacaleg }}
                </td>
                <td class="px-4 py-3 text-sm">
                  {{ $laporan->pelanggaran->jenisPelanggaran->jenis_pelanggaran }}
                </td>
                <td class="px-4 py-3 text-sm">
                  {{ $laporan->pelanggaran->parpol->parpol_name }}
                </td>
                <td class="px-4 py-3 text-sm">
                  @if ($laporan->status == 'approved')
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-500 text-white">
                      Verified
                    </span>
                  @elseif ($laporan->status == 'rejected')
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-500 text-white">
                      Rejected
                    </span>
                  @elseif ($laporan->status == 'pending')
                    <span
                      class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-500 text-white">
                      Pending
                    </span>
                  @endif
                </td>

                <td class="px-4 py-3 text-sm">
                  <div class="flex space-x-2 items-center">
                    <!-- View Button with Icon -->
                    <div>
                      <a href="{{ route('laporanpelanggarans.show', $laporan->id) }}"
                        class="flex items-center px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                          xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                          viewBox="0 0 24 24">
                          <path stroke="currentColor" stroke-width="2"
                            d="M20 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                          <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                      </a>
                    </div>
                    <!-- Edit Button with Icon -->
                    <div>
                      <a href="{{ route('laporanpelanggarans.edit', $laporan->id) }}"
                        class="flex items-center px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-yellow-400 border border-transparent rounded-lg active:bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:shadow-outline-blue"
                        x-show="!('{{ $laporan->status == 'approved' }}')">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                          xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                          viewBox="0 0 24 24">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                        </svg>
                      </a>

                    </div>
                    <!-- Modal Trigger DELETE -->
                    <div x-data="{ openDelete: false }" class="inline">
                      <!-- DELETE BTN -->
                      <button @click="openDelete = true"
                        class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red"
                        x-show="('{{ $laporan->status }}' === 'pending')">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                          xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                          viewBox="0 0 24 24">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                        </svg>
                      </button>
                      <!-- Delete Action -->
                      <div x-show="openDelete"
                        class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75">
                        <div @click.away="openDelete = false"
                          class="bg-white p-6 rounded-lg shadow-lg max-w-md mx-auto">
                          <h2 class="text-lg font-semibold text-gray-900">Confirm Delete</h2>
                          <p class="mt-2 text-sm text-gray-600">Are you sure you want to delete this item?</p>
                          <div class="mt-4 flex justify-end space-x-2">
                            <button @click="openDelete = false"
                              class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
                              Cancel
                            </button>
                            <form action="{{ route('laporanpelanggarans.destroy', $laporan->id) }}" method="POST"
                              class="inline">
                              @csrf
                              @method('DELETE')
                              <button type="submit"
                                class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red">
                                Delete
                              </button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Modal Trigger VERIFY -->
                    <div x-data="{ openVerify: false }" class="inline">
                      <!-- VERIFY Trigger -->
                      <button @click="openVerify = true"
                        class="flex items-center px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue"
                        x-show="('{{ auth()->user()->hasRole('bawaslu-kabupaten-kota') }}' && '{{ $laporan->status }}' === 'pending')">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                          xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                          viewBox="0 0 24 24">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
                        </svg>
                      </button>
                      <!-- VERIFY Action -->
                      <div x-show="openVerify"
                        class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75">
                        <div @click.away="openVerify = false"
                          class="bg-white p-6 rounded-lg shadow-lg max-w-md mx-auto">
                          <h2 class="text-lg font-semibold text-gray-900">Confirm Verification</h2>
                          <p class="mt-2 text-sm text-gray-600">Are you sure you want to verify this?</p>
                          <div class="mt-4 flex justify-end space-x-2">
                            <button @click="openVerify = false"
                              class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
                              Cancel
                            </button>
                            <form action="{{ route('laporanpelanggarans.verif', $laporan->id) }}" method="POST"
                              class="inline">
                              @csrf
                              @method('PATCH')
                              <button type="submit"
                                class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                                Verify
                              </button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Modal Trigger REJECT -->
                    <div x-data="{ openReject: false }" class="inline">
                      <!-- REJECT Trigger -->
                      <button @click="openReject = true"
                        class="flex items-center px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red"
                        x-show="('{{ auth()->user()->hasRole('bawaslu-kabupaten-kota') }}' && '{{ $laporan->status }}' === 'pending')">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                          xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                          viewBox="0 0 24 24">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                      </button>
                      <!-- REJECT Action -->
                      <div x-show="openReject"
                        class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75">
                        <div @click.away="openReject = false"
                          class="bg-white p-6 rounded-lg shadow-lg max-w-md mx-auto">
                          <h2 class="text-lg font-semibold text-gray-900">Confirm Rejection</h2>
                          <p class="mt-2 text-sm text-gray-600">Are you sure you want to reject this?</p>
                          <form action="{{ route('laporanpelanggarans.reject', $laporan->id) }}" method="POST"
                            class="mt-4">
                            @csrf
                            @method('PATCH')
                            <!-- Input for rejection note -->
                            <div class="mb-4">
                              <label for="note" class="block text-sm font-medium text-gray-700">Rejection
                                Note</label>
                              <textarea id="note" name="note" rows="3"
                                class="form-textarea mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-red-600 focus:ring focus:ring-red-600 focus:ring-opacity-50"></textarea>
                            </div>
                            <div class="flex justify-end space-x-2">
                              <button type="button" @click="openReject = false"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
                                Cancel
                              </button>
                              <button type="submit"
                                class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red">
                                Reject
                              </button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div
        class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
        {{ $laporanPelanggarans->links() }}
      </div>
    </div>
  </div>

  <!-- Add this script block to hide the alert after 3 seconds -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      setTimeout(function() {
        var alertSuccess = document.getElementById('alert-success');
        var alertError = document.getElementById('alert-error');
        if (alertSuccess) {
          alertSuccess.style.display = 'none';
        }
        if (alertError) {
          alertError.style.display = 'none';
        }
      }, 3000);
    });
  </script>
</x-app-layout>
