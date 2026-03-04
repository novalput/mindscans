$excludePatterns = @("\vendor\", "\node_modules\", "\storage\", "\.git\", "\.gemini\", "\public\build\")

$files = Get-ChildItem -Path "c:\xampp\htdocs\Projek_part\lia-dent" -Recurse -File | Where-Object {
    $skip = $false
    foreach ($pattern in $excludePatterns) {
        if ($_.FullName -like "*$pattern*") {
            $skip = $true
            break
        }
    }
    # Only process text files like php, blade, js, css, html, json
    if ($_.Extension -notmatch "\.(php|js|jsx|ts|tsx|css|html|json|md|txt)$") {
        $skip = $true
    }
    -not $skip
}

foreach ($file in $files) {
    try {
        $content = Get-Content $file.FullName -Raw
        if ($null -eq $content) { continue }
        
        $newContent = $content -creplace "Patients", "Students"
        $newContent = $newContent -creplace "patients", "students"
        $newContent = $newContent -creplace "PATIENTS", "STUDENTS"
        
        $newContent = $newContent -creplace "Patient", "Student"
        $newContent = $newContent -creplace "patient", "student"
        $newContent = $newContent -creplace "PATIENT", "STUDENT"

        # Note: Nakes in plural contexts:
        $newContent = $newContent -creplace "Nakes", "Lecturer"
        # Table might be "lecturers", but variables might be "lecturer". Since "nakes" = singular/plural, we'll replace "nakes" -> "lecturer"
        $newContent = $newContent -creplace "nakes", "lecturer"
        $newContent = $newContent -creplace "NAKES", "LECTURER"

        if ($content -cne $newContent) {
            Set-Content -Path $file.FullName -Value $newContent -NoNewline
            Write-Host "Updated $($file.FullName)"
        }
    } catch {
        Write-Host "Error processing $($file.FullName): $_"
    }
}
