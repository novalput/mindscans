$excludePatterns = @("\vendor\", "\node_modules\", "\storage\", "\.git\", "\.gemini\", "\public\build\")

# Get all files first
$files = Get-ChildItem -Path "c:\xampp\htdocs\Projek_part\lia-dent" -Recurse -File | Where-Object {
    $skip = $false
    foreach ($pattern in $excludePatterns) {
        if ($_.FullName -like "*$pattern*") {
            $skip = $true
            break
        }
    }
    -not $skip
}

foreach ($file in $files) {
    $newName = $file.Name
    $renamed = $false

    if ($newName -match "Patient") {
        $newName = $newName -replace "Patient", "Student"
        $renamed = $true
    }
    elseif ($newName -match "patient") {
        $newName = $newName -replace "patient", "student"
        $renamed = $true
    }

    if ($newName -match "Nakes") {
        $newName = $newName -replace "Nakes", "Lecturer"
        $renamed = $true
    }
    elseif ($newName -match "nakes") {
        $newName = $newName -replace "nakes", "lecturer"
        $renamed = $true
    }

    if ($renamed) {
        $newPath = Join-Path $file.Directory.FullName $newName
        Rename-Item -Path $file.FullName -NewName $newName
        Write-Host "Renamed $( $file.FullName ) to $newPath"
    }
}
