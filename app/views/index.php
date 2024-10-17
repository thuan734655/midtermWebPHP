<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Danh bạ</title>
    <style>
    /* Các kiểu cho mobile */
    @media (max-width: 576px) {
        body {
            background-color: #f8f9fa;
        }

        .container {
            padding: 10px;
        }

        h2 {
            font-size: 1.5rem;
        }

        .btn {
            width: 100%;
            margin-bottom: 10px;
        }
    }

    /* Các kiểu cho tablet */
    @media (min-width: 577px) and (max-width: 768px) {
        body {
            background-color: #e9ecef;
        }

        h2 {
            font-size: 2rem;
        }

        .btn {
            width: auto;
        }
    }

    /* Các kiểu cho desktop */
    @media (min-width: 769px) {
        body {
            background-color: #ffffff;
        }

        .container {
            max-width: 800px;
            margin-top: 20px;
        }

        h2 {
            font-size: 2.5rem;
        }
    }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h2>Danh bạ</h2>
        <form id="searchForm" class="mb-3">
            <div class="input-group">
                <input type="text" name="query" class="form-control" placeholder="Tìm kiếm..." required>
                <div class="input-group-append">
                    <button type="submit" class="btn btn-secondary">Tìm kiếm</button>
                </div>
            </div>
        </form>
        <button id="addContactBtn" class="btn btn-success mb-3">Thêm liên hệ</button>

        <div id="addContactForm" class="mb-3" style="display:none;">
            <h3>Thêm liên hệ</h3>
            <form id="newContactForm">
                <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Tên" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="text" name="phone" class="form-control" placeholder="Điện thoại" required>
                </div>
                <div class="form-group">
                    <input type="text" name="img" class="form-control" placeholder="Đường dẫn hình ảnh" required>
                </div>
                <button type="submit" class="btn btn-primary">Lưu</button>
                <button type="button" class="btn btn-secondary" id="cancelAdd">Hủy</button>
            </form>
        </div>

        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Điện thoại</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="contactsTable">
                <?php foreach ($contacts as $contact): ?>
                <tr data-id="<?= $contact['id'] ?>">
                    <td><?= htmlspecialchars($contact['name']) ?></td>
                    <td><?= htmlspecialchars($contact['email']) ?></td>
                    <td><?= htmlspecialchars($contact['phone']) ?></td>
                    <td>
                        <button class="btn btn-danger deleteBtn">Xóa</button>
                        <button class="btn btn-info viewBtn">Xem chi tiết</button>
                        <button class="btn btn-warning editBtn">Sửa</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal để xem chi tiết -->
    <div class="modal fade" id="viewModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thông tin liên hệ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="contactName"></p>
                    <p id="contactEmail"></p>
                    <p id="contactPhone"></p>
                    <img id="contactImage" src="" alt="Hình ảnh liên hệ" class="img-fluid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal để sửa liên hệ -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sửa thông tin liên hệ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Tên" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="phone" class="form-control" placeholder="Điện thoại" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="img" class="form-control" placeholder="Đường dẫn hình ảnh"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        // Tìm kiếm liên hệ
        $('#searchForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'ajax.php',
                data: $(this).serialize() + '&action=search',
                success: function(response) {
                    const result = JSON.parse(response);
                    if (result.status === 'success') {
                        const contacts = result.contacts;
                        let rows = '';
                        contacts.forEach(contact => {
                            rows += `<tr data-id="${contact.id}">
                                    <td>${contact.name}</td>
                                    <td>${contact.email}</td>
                                    <td>${contact.phone}</td>
                                    <td>
                                        <button class="btn btn-danger deleteBtn">Xóa</button>
                                        <button class="btn btn-info viewBtn">Xem chi tiết</button>
                                        <button class="btn btn-warning editBtn">Sửa</button>
                                    </td>
                                  </tr>`;
                        });
                        $('#contactsTable').html(rows);
                    }
                }
            });
        });

        // Xóa liên hệ
        $(document).on('click', '.deleteBtn', function() {
            const row = $(this).closest('tr');
            const id = row.data('id');

            $.ajax({
                type: 'POST',
                url: 'ajax.php',
                data: {
                    action: 'delete',
                    id: id
                },
                success: function(response) {
                    const result = JSON.parse(response);
                    if (result.status === 'success') {
                        row.remove(); // Xóa hàng khỏi bảng
                    }
                }
            });
        });

        // Hiện form thêm liên hệ
        $('#addContactBtn').on('click', function() {
            $('#addContactForm').toggle();
        });

        // Thêm liên hệ qua form
        $('#newContactForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'ajax.php',
                data: $(this).serialize() + '&action=add',
                success: function(response) {
                    const result = JSON.parse(response);
                    if (result.status === 'success') {
                        location.reload(); // Tải lại trang để cập nhật
                    }
                }
            });
        });

        // Hủy thao tác thêm
        $('#cancelAdd').on('click', function() {
            $('#addContactForm').hide();
        });

        // Xem chi tiết liên hệ
        $(document).on('click', '.viewBtn', function() {
            const row = $(this).closest('tr');
            const id = row.data('id');

            $.ajax({
                type: 'POST',
                url: 'ajax.php',
                data: {
                    action: 'view',
                    id: id
                },
                success: function(response) {
                    const result = JSON.parse(response);
                    if (result.status === 'success') {
                        $('#contactName').text(`Tên: ${result.contact.name}`);
                        $('#contactEmail').text(`Email: ${result.contact.email}`);
                        $('#contactPhone').text(`Điện thoại: ${result.contact.phone}`);
                        $('#contactImage').attr('src', result.contact.img);
                        $('#viewModal').modal('show');
                    }
                }
            });
        });

        // Sửa liên hệ
        $(document).on('click', '.editBtn', function() {
            const row = $(this).closest('tr');
            const id = row.data('id');

            $.ajax({
                type: 'POST',
                url: 'ajax.php',
                data: {
                    action: 'edit',
                    id: id
                },
                success: function(response) {
                    const result = JSON.parse(response);
                    if (result.status === 'success') {
                        $('#editForm input[name="name"]').val(result.contact.name);
                        $('#editForm input[name="email"]').val(result.contact.email);
                        $('#editForm input[name="phone"]').val(result.contact.phone);
                        $('#editForm input[name="img"]').val(result.contact.img);
                        $('#editForm').data('id', result.contact.id);
                        $('#editModal').modal('show');
                    }
                }
            });
        });

        // Lưu thông tin sau khi sửa
        $('#editForm').on('submit', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            $.ajax({
                type: 'POST',
                url: 'ajax.php',
                data: {
                    action: 'update',
                    id: id,
                    name: $('#editForm input[name="name"]').val(),
                    email: $('#editForm input[name="email"]').val(),
                    phone: $('#editForm input[name="phone"]').val(),
                    img: $('#editForm input[name="img"]').val()
                },
                success: function(response) {
                    const result = JSON.parse(response);
                    if (result.status === 'success') {
                        location.reload(); // Tải lại trang để cập nhật
                    }
                }
            });
        });
    });
    </script>
</body>

</html>