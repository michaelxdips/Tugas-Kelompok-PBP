<?php
session_start();

// Ambil data lama & error dari session (jika ada)
$formData = $_SESSION['form_data'] ?? [];
$errors   = $_SESSION['errors'] ?? [];

if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas PBP</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 850px;
            margin: 30px auto;
            padding: 20px;
        }

        .form-container {
            background-color: #fff;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h1 {
            margin: 0 0 25px 0;
            padding: 18px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-radius: 8px;
            font-size: 22px;
            font-weight: bold;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }

        .nama-baris {
            width: 180px;
            font-weight: bold;
            color: #444;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            margin-bottom: 5px;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #667eea;
            outline: none;
            box-shadow: 0 0 6px rgba(102, 126, 234, 0.4);
        }

        .note {
            font-size: 13px;
            color: #777;
            margin-top: 4px;
        }

        .radio-group,
        .checkbox-group {
            margin: 6px 0;
        }

        .radio-group input,
        .checkbox-group input {
            accent-color: #667eea;
        }

        .radio-group label,
        .checkbox-group label {
            margin-left: 6px;
            font-weight: normal;
            color: #333;
        }

        .submit-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 14px 35px;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-size: 17px;
            margin: 25px auto;
            display: block;
            font-weight: bold;
            box-shadow: 0 5px 15px rgba(118, 75, 162, 0.3);
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, #5a67d8, #6b46c1);
            transform: translateY(-2px);
            box-shadow: 0 7px 20px rgba(118, 75, 162, 0.5);
        }

        .alert {
            padding: 15px;
            margin: 20px 0;
            border-radius: 6px;
            font-weight: bold;
            animation: fadeIn 0.5s ease-in-out;
        }

        .alert-error {
            background-color: #fdecea;
            color: #b71c1c;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <?php if (!empty($errors)): ?>
            <script>
                alert("<?= implode('\n', array_map('addslashes', $errors)) ?>");
            </script>
        <?php endif; ?>

        <h1>Student Sign On Form</h1>

        <form method="POST" action="proccess.php">
            <table>
                <tr>
                    <td class="nama-baris">Username</td>
                    <td>
                        <input type="text" name="username" value="<?php echo htmlspecialchars($formData['username'] ?? ''); ?>">
                        <div class="note">Note: Username cannot contain numbers</div>
                    </td>
                </tr>

                <tr>
                    <td class="nama-baris">Email</td>
                    <td>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($formData['email'] ?? ''); ?>">
                        <div class="note">Note: Email contain @ followed by domain</div>
                    </td>
                </tr>

                <tr>
                    <td class="nama-baris">Perguruan Tinggi</td>
                    <td>
                        <input type="text" name="perguruan_tinggi" value="<?php echo htmlspecialchars($formData['perguruan_tinggi'] ?? ''); ?>">
                    </td>
                </tr>

                <tr>
                    <td class="nama-baris">Program Studi</td>
                    <td>
                        <div class="radio-group">
                            <input type="radio" id="informatika" name="program_studi" value="Informatika" <?php echo (($formData['program_studi'] ?? '') === 'Informatika') ? 'checked' : ''; ?>>
                            <label for="informatika">Informatika</label>
                        </div>
                        <div class="radio-group">
                            <input type="radio" id="matematika" name="program_studi" value="Matematika" <?php echo (($formData['program_studi'] ?? '') === 'Matematika') ? 'checked' : ''; ?>>
                            <label for="matematika">Matematika</label>
                        </div>
                        <div class="radio-group">
                            <input type="radio" id="fisika" name="program_studi" value="Fisika" <?php echo (($formData['program_studi'] ?? '') === 'Fisika') ? 'checked' : ''; ?>>
                            <label for="fisika">Fisika</label>
                        </div>
                        <div class="radio-group">
                            <input type="radio" id="kimia" name="program_studi" value="Kimia" <?php echo (($formData['program_studi'] ?? '') === 'Kimia') ? 'checked' : ''; ?>>
                            <label for="kimia">Kimia</label>
                        </div>
                        <div class="radio-group">
                            <input type="radio" id="statistika" name="program_studi" value="Statistika" <?php echo (($formData['program_studi'] ?? '') === 'Statistika') ? 'checked' : ''; ?>>
                            <label for="statistika">Statistika</label>
                        </div>
                        <div class="radio-group">
                            <input type="radio" id="biologi" name="program_studi" value="Biologi" <?php echo (($formData['program_studi'] ?? '') === 'Biologi') ? 'checked' : ''; ?>>
                            <label for="biologi">Biologi</label>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="nama-baris">Hobi:</td>
                    <td>
                        <div class="checkbox-group">
                            <input type="checkbox" id="futsal" name="hobi[]" value="Futsal" <?php echo in_array('Futsal', $formData['hobi'] ?? []) ? 'checked' : ''; ?>>
                            <label for="futsal">Futsal</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="badminton" name="hobi[]" value="Badminton" <?php echo in_array('Badminton', $formData['hobi'] ?? []) ? 'checked' : ''; ?>>
                            <label for="badminton">Badminton</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="membaca" name="hobi[]" value="Membaca" <?php echo in_array('Membaca', $formData['hobi'] ?? []) ? 'checked' : ''; ?>>
                            <label for="membaca">Membaca</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="menulis" name="hobi[]" value="Menulis" <?php echo in_array('Menulis', $formData['hobi'] ?? []) ? 'checked' : ''; ?>>
                            <label for="menulis">Menulis</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="travelling" name="hobi[]" value="Travelling" <?php echo in_array('Travelling', $formData['hobi'] ?? []) ? 'checked' : ''; ?>>
                            <label for="travelling">Travelling</label>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="nama-baris">Password</td>
                    <td>
                        <input type="password" name="password" value="<?php echo htmlspecialchars($formData['password'] ?? ''); ?>">
                        <div class="note">hint: Password must be at least 8 characters long, include at least one uppercase letter, one lowercase letter, and one number.</div>
                    </td>
                </tr>
            </table>

            <button type="submit" class="submit-btn">Submit</button>
        </form>
    </div>
</body>

</html>
