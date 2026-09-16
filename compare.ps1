$names = @('home','informasi','profil','publikasi','2025','2026','2024')
foreach ($n in $names) {
    $a = (((Get-Content -Raw "out-$n.html") -replace '(?s)/\*.*?\*/','') -replace '\s+',' ')
    $b = (((Get-Content -Raw "new-$n.html") -replace '(?s)/\*.*?\*/','') -replace '\s+',' ')
    $m = [Math]::Min($a.Length, $b.Length)
    $i = 0
    while ($i -lt $m -and $a[$i] -eq $b[$i]) { $i++ }
    Write-Output "$n : lenA=$($a.Length) lenB=$($b.Length) firstDiff=$i"
    if ($i -lt $m) {
        $s = [Math]::Max(0, $i - 90)
        Write-Output ("  A: " + $a.Substring($s, 200))
        Write-Output ("  B: " + $b.Substring($s, 200))
    }
}