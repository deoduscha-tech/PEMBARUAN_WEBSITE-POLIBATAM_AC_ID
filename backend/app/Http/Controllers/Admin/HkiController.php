<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\HkiRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HkiController extends Controller
{
    public function __construct(private HkiRepository $hki) {}

    public function index(): View
    {
        $years = $this->hki->all();
        krsort($years);
        return view('admin.hki.index', ['years' => $years]);
    }

    public function create(): View
    {
        return view('admin.hki.form', ['year' => null, 'record' => null]);
    }

    public function edit(int $year): View
    {
        $record = $this->hki->find($year);
        abort_if($record === null, 404);
        return view('admin.hki.form', ['year' => $year, 'record' => $record]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        if ($this->hki->find((int) $data['year']) !== null) {
            return back()->withErrors(['year' => 'Data HKI untuk tahun tersebut sudah ada.'])->withInput();
        }
        $this->hki->saveYear((int) $data['year'], $this->buildRecord($data, 0));
        return redirect()->route('admin.hki.index')->with('success', 'Data HKI tahun ' . $data['year'] . ' berhasil ditambahkan.');
    }

    public function update(Request $request, int $year): RedirectResponse
    {
        $record = $this->hki->find($year);
        abort_if($record === null, 404);
        $data = $this->validated($request, false);
        $this->hki->saveYear($year, $this->buildRecord($data, (int) ($record['views'] ?? 0)));
        return redirect()->route('admin.hki.index')->with('success', 'Data HKI tahun ' . $year . ' berhasil diperbarui.');
    }

    public function destroy(int $year): RedirectResponse
    {
        abort_if($this->hki->deleteYear($year) === false, 404);
        return redirect()->route('admin.hki.index')->with('success', 'Arsip HKI tahun ' . $year . ' berhasil dihapus.');
    }

    private function validated(Request $request, bool $includeYear = true): array
    {
        $rules = [
            'daftar' => ['required', 'array', 'min:1'],
            'daftar.*.judul' => ['required', 'string', 'max:500'],
            'daftar.*.jenis' => ['required', 'string', 'max:150'],
            'daftar.*.pencipta' => ['required', 'string', 'max:500'],
            'daftar.*.nomor' => ['nullable', 'string', 'max:200'],
        ];
        if ($includeYear) $rules['year'] = ['required', 'integer', 'between:1900,2100'];
        $data = $request->validate($rules);
        if (!$includeYear) $data['year'] = (int) $request->route('year');
        $data['daftar'] = array_values(array_map(static fn ($row) => [
            'judul' => trim($row['judul']),
            'jenis' => trim($row['jenis']),
            'pencipta' => trim($row['pencipta']),
            'nomor' => trim((string) ($row['nomor'] ?? '')),
        ], $data['daftar']));
        return $data;
    }

    private function buildRecord(array $data, int $views): array
    {
        $counts = [];
        foreach ($data['daftar'] as $row) {
            $counts[$row['jenis']] = ($counts[$row['jenis']] ?? 0) + 1;
        }
        $breakdown = [];
        foreach ($counts as $jenis => $jumlah) $breakdown[] = ['jumlah' => $jumlah, 'jenis' => $jenis];
        return [
            'views' => $views,
            'show_summary' => true,
            'ringkasan' => ['total' => count($data['daftar']), 'rincian' => $breakdown],
            'kolom' => ['Judul', 'Jenis HKI', 'Nama Pencipta', 'Nomor Permohonan'],
            'daftar' => $data['daftar'],
        ];
    }
}
