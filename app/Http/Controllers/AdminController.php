<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Models\Dokumen;
use App\Models\JenisUsaha;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $selectedYear = $request->year ?? date('Y');

        // ========== DATA DOKUMEN ==========
        $totalDokumen = Dokumen::count();

        // Dokumen berdasarkan status
        $dokumenAktif = Dokumen::where('status', 'approved')->count();
        $dokumenPending = Dokumen::where('status', 'review')->count();
        $dokumenArsip = Dokumen::where('status', 'draft')->count();

        // Dokumen baru bulan ini
        $dokumenBaru = Dokumen::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->count();

        // Dokumen baru hari ini
        $dokumenHariIni = Dokumen::whereDate('created_at', Carbon::today())->count();

        // Dokumen revisi (versi > 1)
        $dokumenRevisi = Dokumen::where('versi', '>', 1)->count();

        // Total versi dokumen
        $totalVersi = Dokumen::sum('versi');

        // Dokumen dengan file
        $dokumenDenganFile = Dokumen::whereNotNull('file_path')->count();

        // ========== DATA KATEGORI ==========
        $totalKategori = JenisUsaha::count();
        // $kategoriAktif = JenisUsaha::where('status', 'aktif')->count();

        // Top 5 kategori dengan dokumen terbanyak
        $topKategori = JenisUsaha::withCount('dokumen')
            ->orderBy('dokumen_count', 'desc')
            ->take(5)
            ->get();

        // Kategori tanpa dokumen
        $kategoriKosong = JenisUsaha::withCount('dokumen')
            ->having('dokumen_count', 0)
            ->count();

        // ========== DATA PENGGUNA ==========
        $totalUsers = User::count();
        $userBaru = User::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->count();
        // $userAktif = User::where('status', 'aktif')->count();

        // Top 5 pengguna dengan dokumen terbanyak
        $topUsers = User::withCount('dokumen')
            ->orderBy('dokumen_count', 'desc')
            ->take(5)
            ->get();

        // Pengguna tanpa dokumen
        $userTanpaDokumen = User::withCount('dokumen')
            ->having('dokumen_count', 0)
            ->count();

        // ========== CHART DATA ==========
        // Monthly upload trend
        $monthlyUploads = [];
        $monthLabels = [];
        for ($i = 1; $i <= 12; $i++) {
            $month = Carbon::create($selectedYear, $i, 1);
            $monthLabels[] = $month->format('M');

            $count = Dokumen::whereYear('created_at', $selectedYear)
                ->whereMonth('created_at', $i)
                ->count();
            $monthlyUploads[] = $count;
        }

        // Category distribution - FIXED
        $categories = JenisUsaha::withCount('dokumen')
            ->orderBy('dokumen_count', 'desc')
            ->take(8)
            ->get();

        $categoryData = [];
        $categoryLabels = [];
        foreach ($categories as $category) {
            if ($category->dokumen_count > 0) {
                $categoryLabels[] = $category->nama;
                $categoryData[] = $category->dokumen_count;
            }
        }

        // Top users data for chart - FIXED
        $topUsersList = User::withCount('dokumen')
            ->orderBy('dokumen_count', 'desc')
            ->take(5)
            ->get();

        $topUsersData = [];
        $topUsersLabels = [];
        foreach ($topUsersList as $user) {
            if ($user->dokumen_count > 0) {
                $topUsersLabels[] = $user->name;
                $topUsersData[] = $user->dokumen_count;
            }
        }

        // Version distribution - FIXED
        $versionData = [];
        $versionLabels = [];
        $versionGroups = Dokumen::selectRaw('versi, count(*) as total')
            ->groupBy('versi')
            ->orderBy('versi')
            ->get();

        foreach ($versionGroups as $group) {
            $versionLabels[] = 'v' . $group->versi;
            $versionData[] = $group->total;
        }

        // Monthly statistics - FIXED with proper month names
        $monthlyStats = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthName = $month->format('M Y');

            $uploads = Dokumen::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();

            $revisions = Dokumen::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->where('versi', '>', 1)
                ->count();

            $monthlyStats[] = [
                'month' => $monthName,
                'month_num' => $month->month,
                'year' => $month->year,
                'uploads' => $uploads,
                'revisions' => $revisions,
                'total' => $uploads + $revisions
            ];
        }

        // ========== ACTIVITY STATISTICS ==========
        $uploadBulanIni = Dokumen::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->count();

        $uploadMingguIni = Dokumen::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();

        // Real download count (if you have downloads table) or use view count as alternative
        // $downloadBulanIni = DB::table('dokumen_views')
        //     ->whereMonth('created_at', date('m'))
        //     ->whereYear('created_at', date('Y'))
        //     ->count() ?? rand(50, 200);

        // $viewBulanIni = DB::table('dokumen_views')
        //     ->whereMonth('created_at', date('m'))
        //     ->whereYear('created_at', date('Y'))
        //     ->count() ?? rand(100, 500);

        // Recent documents
        $recentDocuments = Dokumen::with(['kategori', 'user'])
            ->latest()
            ->take(10)
            ->get();

        // ========== GROWTH CALCULATIONS ==========
        // Document growth compared to last month
        $lastMonthUploads = Dokumen::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();

        $growthPercentage = $lastMonthUploads > 0
            ? round((($uploadBulanIni - $lastMonthUploads) / $lastMonthUploads) * 100, 1)
            : 0;

        // ========== STATUS DISTRIBUTION FOR CHART ==========
        $statusData = [
            'Aktif' => $dokumenAktif,
            'Pending' => $dokumenPending,
            'Arsip' => $dokumenArsip
        ];

        return view('pages.admin.dashboard.index', [
            'menu' => 'dashboard',

            // Document data
            'totalDokumen' => $totalDokumen,
            'dokumenAktif' => $dokumenAktif,
            'dokumenPending' => $dokumenPending,
            'dokumenArsip' => $dokumenArsip,
            'dokumenBaru' => $dokumenBaru,
            'dokumenHariIni' => $dokumenHariIni,
            'dokumenRevisi' => $dokumenRevisi,
            'totalVersi' => $totalVersi,
            'dokumenDenganFile' => $dokumenDenganFile,
            'growthPercentage' => $growthPercentage,

            // Category data
            'totalKategori' => $totalKategori,
            // 'kategoriAktif' => $kategoriAktif,
            'kategoriKosong' => $kategoriKosong,
            'topKategori' => $topKategori,

            // User data
            'totalUsers' => $totalUsers,
            'userBaru' => $userBaru,
            // 'userAktif' => $userAktif,
            'userTanpaDokumen' => $userTanpaDokumen,
            'topUsers' => $topUsers,

            // Chart data
            'monthlyUploads' => $monthlyUploads,
            'monthLabels' => $monthLabels,
            'categoryData' => $categoryData,
            'categoryLabels' => $categoryLabels,
            'topUsersData' => $topUsersData,
            'topUsersLabels' => $topUsersLabels,
            'versionData' => $versionData,
            'versionLabels' => $versionLabels,
            'monthlyStats' => $monthlyStats,
            'statusData' => $statusData,

            // Activity data
            'uploadBulanIni' => $uploadBulanIni,
            'uploadMingguIni' => $uploadMingguIni,
            // 'downloadBulanIni' => $downloadBulanIni,
            // 'viewBulanIni' => $viewBulanIni,

            // Recent data
            'recentDocuments' => $recentDocuments,

            // Filter
            'selectedYear' => $selectedYear
        ]);
    }

    public function profile($id)
    {
        $data = User::findOrFail($id);

        return view('pages.admin.profile.index', [
            'menu' => 'profile',
            'data' => $data
        ]);
    }

    public function profile_update(Request $request)
    {
        $user = User::findOrFail($request->id);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'jabatan' => 'required|string|max:255',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->jabatan = $request->jabatan;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()
            ->back()
            ->with('message', 'Profil berhasil diperbarui.');
    }
}
