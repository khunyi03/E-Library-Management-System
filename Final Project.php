<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: 'Inter', sans-serif; /* Example font */
        }

        main {
            flex: 1; /* Ensures main content takes up available space */
        }

        .book-card {
            height: 100%; /* Make cards in a row equal height */
        }

        .footer {
            background-color: #f8f9fa; /* Light background for footer */
            padding: 1rem 0;
            margin-top: auto; /* Push footer to bottom */
        }
        /* Add more custom styles here */
        .navbar {
            border-radius: 0.5rem; /* Rounded corners for navbar */
            margin-bottom: 1.5rem; /* Space below navbar */
        }

        .btn {
            border-radius: 0.5rem; /* Rounded corners for buttons */
        }

        .card {
            border-radius: 0.5rem; /* Rounded corners for cards */
        }

        .form-control, .form-select {
            border-radius: 0.5rem; /* Rounded corners for form inputs */
        }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

    <?php if (isset($_GET['logout'])): ?>
        <div class="alert alert-info alert-dismissible fade show text-center" role="alert">
            You’ve been logged out.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>


    <header class="container mt-3">
        <nav class="navbar navbar-expand-lg navbar-light bg-light p-3">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">E-Library</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#browse">Browse Books</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#dashboard">My Dashboard</a>
                        </li>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <li class="nav-item">
                                 <a class="nav-link" href="#admin">Admin</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <div class="d-flex align-items-center">
    			<?php if (isset($_SESSION['user_id'])): ?>
        			<span class="me-2">Welcome, <?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></span>
        			<a href="logout.php" class="btn btn-outline-danger">Logout</a>
    			<?php else: ?>
        			<button class="btn btn-outline-primary me-2" type="button" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
        			<button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#registerModal">Register</button>
    			<?php endif; ?>
                </div>
            </div>
        </nav>
    </header>

    <main class="container my-4">

        <section id="home">
            <h2>Welcome to the E-Library!</h2>
            <p>Discover new arrivals, featured books, and more.</p>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card book-card">
                        <img src="https://placehold.co/600x400/EEE/31343C?text=Book+Cover" class="card-img-top" alt="Book Cover Placeholder" onerror="this.src='https://placehold.co/600x400/EEE/31343C?text=Image+Error'">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Featured Book 1</h5>
                            <p class="card-text">Brief description of the featured book.</p>
                            <a href="#book-detail" class="btn btn-primary mt-auto">View Details</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card book-card">
                        <img src="https://placehold.co/600x400/DDD/31343C?text=Book+Cover" class="card-img-top" alt="Book Cover Placeholder" onerror="this.src='https://placehold.co/600x400/EEE/31343C?text=Image+Error'">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">New Arrival</h5>
                            <p class="card-text">Another interesting book available now.</p>
                            <a href="#book-detail" class="btn btn-primary mt-auto">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="browse" style="display: none;">
            <h2>Browse Books</h2>
            <form id="search-filter-form" class="row g-3 mb-4 align-items-end">
                <div class="col-md-6">
                    <label for="searchInput" class="form-label">Search by Title, Author, Keyword</label>
                    <input type="text" class="form-control" id="searchInput" placeholder="e.g., The Great Gatsby, F. Scott Fitzgerald">
                </div>
                <div class="col-md-3">
                    <label for="genreFilter" class="form-label">Filter by Genre</label>
                    <select id="genreFilter" class="form-select">
                        <option selected value="">All Genres</option>
                        <option value="fiction">Fiction</option>
                        <option value="mystery">Mystery</option>
                        <option value="science">Science</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="availabilityFilter" class="form-label">Filter by Availability</label>
                    <select id="availabilityFilter" class="form-select">
                        <option selected value="">All</option>
                        <option value="available">Available</option>
                        <option value="borrowed">Borrowed</option>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Search / Filter</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </form>

            <div id="book-list" class="row">
                <div class="col-md-4 mb-3">
                    <div class="card book-card">
                        <img src="https://placehold.co/600x400/CCC/31343C?text=Book+Cover" class="card-img-top" alt="Book Cover Placeholder" onerror="this.src='https://placehold.co/600x400/EEE/31343C?text=Image+Error'">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Book Title</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Author Name</h6>
                            <p class="card-text">Genre: Fiction</p>
                            <p class="card-text"><span class="badge bg-success">Available</span></p> <a href="#book-detail" class="btn btn-secondary mt-auto view-details-btn" data-book-id="1">View Details</a>
                        </div>
                    </div>
                </div>
                <p class="text-center mt-3">Loading books...</p>
            </div>
        </section>

        <section id="book-detail" style="display: none;">
            <button class="btn btn-sm btn-outline-secondary mb-3" id="back-to-browse-btn">&lt; Back to Browse</button>
            <div class="row">
                <div class="col-md-4">
                    <img src="https://placehold.co/600x800/BBB/31343C?text=Book+Cover" id="detail-book-cover" class="img-fluid rounded" alt="Book Cover" onerror="this.src='https://placehold.co/600x800/EEE/31343C?text=Image+Error'">
                </div>
                <div class="col-md-8">
                    <h2 id="detail-book-title">Book Title</h2>
                    <h4 id="detail-book-author">Author Name</h4>
                    <p><strong>Genre:</strong> <span id="detail-book-genre">Genre</span></p>
                    <p><strong>ISBN:</strong> <span id="detail-book-isbn">ISBN</span></p>
                    <p><strong>Description:</strong> <span id="detail-book-description">Detailed description of the book goes here...</span></p>
                    <p><strong>Status:</strong> <span id="detail-book-status" class="badge bg-success">Available</span></p>
                    <button id="borrow-return-btn" class="btn btn-primary" data-book-id="">Borrow Book</button>
                    <p id="borrow-message" class="text-danger mt-2" style="display: none;"></p>
                </div>
            </div>
        </section>

        <section id="dashboard" style="display: none;">
            <h2>My Dashboard</h2>
            <h4>My Borrowed Books</h4>
            <div id="borrowed-books-list">
                <div class="list-group">
                    <div class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">Borrowed Book Title 1</h5>
                            <small>Due: YYYY-MM-DD</small>
                        </div>
                        <p class="mb-1">Author Name</p>
                        <button class="btn btn-sm btn-warning return-btn" data-loan-id="1">Return Book</button>
                    </div>
                    <div class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">Borrowed Book Title 2</h5>
                            <small class="text-danger">Overdue: YYYY-MM-DD</small>
                        </div>
                        <p class="mb-1">Author Name</p>
                        <button class="btn btn-sm btn-warning return-btn" data-loan-id="2">Return Book</button>
                    </div>
                    <p class="mt-3">You have no books currently borrowed.</p>
                </div>
            </div>
            <h4 class="mt-4">Borrowing History</h4>
            <div id="borrowing-history">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Borrowed On</th>
                            <th>Returned On</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>History Book 1</td>
                            <td>Author X</td>
                            <td>YYYY-MM-DD</td>
                            <td>YYYY-MM-DD</td>
                        </tr>
                        <tr><td colspan="4" class="text-center">No borrowing history found.</td></tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="admin" style="display: none;">
            <h2>Admin Dashboard</h2>
            <ul class="nav nav-tabs" id="adminTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="manage-books-tab" data-bs-toggle="tab" data-bs-target="#manage-books" type="button" role="tab" aria-controls="manage-books" aria-selected="true">Manage Books</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="manage-users-tab" data-bs-toggle="tab" data-bs-target="#manage-users" type="button" role="tab" aria-controls="manage-users" aria-selected="false">Manage Users</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="manage-loans-tab" data-bs-toggle="tab" data-bs-target="#manage-loans" type="button" role="tab" aria-controls="manage-loans" aria-selected="false">View Loans</button>
                </li>
            </ul>
            <div class="tab-content" id="adminTabContent">
                <div class="tab-pane fade show active p-3" id="manage-books" role="tabpanel" aria-labelledby="manage-books-tab">
                    <h4>Add/Edit Books</h4>
                    <form id="add-edit-book-form" class="mb-4 border p-3 rounded">
                        <input type="hidden" id="edit-book-id" name="id"> 

                        <div class="mb-3">
                            <label for="bookTitle" class="form-label">Title</label>
                            <input type="text" class="form-control" id="bookTitle" name="title" required>
                        </div>

                        <div class="mb-3">
                            <label for="bookAuthor" class="form-label">Author</label>
                            <input type="text" class="form-control" id="bookAuthor" name="author" required>
                        </div>

                        <div class="mb-3">
                            <label for="bookGenre" class="form-label">Genre</label>
                            <input type="text" class="form-control" id="bookGenre" name="genre">
                        </div>

                        <div class="mb-3">
                            <label for="bookISBN" class="form-label">ISBN</label>
                            <input type="text" class="form-control" id="bookISBN" name="isbn">
                        </div>

                        <div class="mb-3">
                            <label for="bookDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="bookDescription" name="description" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="bookCoverUrl" class="form-label">Cover Image URL</label>
                            <input type="url" class="form-control" id="bookCoverUrl" name="cover_url" placeholder="https://...">
                        </div>

                        <p id="admin-book-message" class="text-success mt-2" style="display:none;"></p>

                        <button type="submit" class="btn btn-success">Save Book</button>
                        <button type="reset" class="btn btn-secondary">Clear Form</button>
                    </form>

                    <h4>Existing Books</h4>
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr><th>Title</th><th>Author</th><th>Genre</th><th>ISBN</th><th>Status</th><th>Actions</th></tr>
                        </thead>
                        <tbody id="admin-book-list">
                            <tr>
                                <td>Sample Book</td>
                                <td>Sample Author</td>
                                <td>Fiction</td>
                                <td>1234567890</td>
                                <td><span class="badge bg-success">Available</span></td>
                                <td>
                                    <button class="btn btn-sm btn-info edit-book-btn" data-book-id="1">Edit</button>
                                    <button class="btn btn-sm btn-danger delete-book-btn" data-book-id="1">Delete</button>
                                </td>
                            </tr>
                            <tr><td colspan="6" class="text-center">Loading books...</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade p-3" id="manage-users" role="tabpanel" aria-labelledby="manage-users-tab">
                    <h4>User Management</h4>
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr><th>Username</th><th>Email</th><th>Member Since</th><th>Actions</th></tr>
                        </thead>
                        <tbody id="admin-user-list">
                            <tr>
                                <td>john_doe</td>
                                <td>john@example.com</td>
                                <td>YYYY-MM-DD</td>
                                <td>
                                    <button class="btn btn-sm btn-warning suspend-user-btn" data-user-id="1">Suspend</button>
                                    <button class="btn btn-sm btn-danger delete-user-btn" data-user-id="1">Delete</button>
                                </td>
                            </tr>
                            <tr><td colspan="4" class="text-center">Loading users...</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade p-3" id="manage-loans" role="tabpanel" aria-labelledby="manage-loans-tab">
                    <h4>Loan History</h4>
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr><th>Book Title</th><th>User</th><th>Borrowed On</th><th>Due Date</th><th>Returned On</th><th>Status</th></tr>
                        </thead>
                        <tbody id="admin-loan-list">
                            <tr>
                                <td>Sample Book</td>
                                <td>john_doe</td>
                                <td>YYYY-MM-DD</td>
                                <td>YYYY-MM-DD</td>
                                <td>-</td>
                                <td><span class="badge bg-warning">Borrowed</span></td>
                            </tr>
                            <tr>
                                <td>Another Book</td>
                                <td>jane_doe</td>
                                <td>YYYY-MM-DD</td>
                                <td>YYYY-MM-DD</td>
                                <td>YYYY-MM-DD</td>
                                <td><span class="badge bg-secondary">Returned</span></td>
                            </tr>
                            <tr><td colspan="6" class="text-center">Loading loan data...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    </main>

    <footer class="footer mt-auto py-3 bg-light">
        <div class="container text-center">
            <span class="text-muted">&copy; 2025 E-Library. All rights reserved.</span>
        </div>
    </footer>

    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-3">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="login-form" method="POST">
                        <div class="mb-3">
                            <label for="loginUsername" class="form-label">Username or Email</label>
                            <input type="email" class="form-control" id="loginEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="loginPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="loginPassword" name="password" required>
                        </div>
                        <p id="login-error" class="text-danger" style="display: none;"></p> <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-3">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Register</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="register-form" method="POST">
                        <div class="mb-3">
                            <label for="registerUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" id="registerUsername" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="registerEmail" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="registerEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="registerPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="registerPassword" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="registerConfirmPassword" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="registerConfirmPassword" name="confirm_password" required>
                        </div>
                        <p id="register-success" class="text-success" style="display: none;"></p>
                        <p id="register-error" class="text-danger" style="display: none;"></p> <button type="submit" class="btn btn-primary w-100">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        // --- Basic Page Navigation (Example) ---
        // This is a very simple way to show/hide sections.
        // A real app might use URL routing or more complex state management.
        const sections = document.querySelectorAll('main > section');
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

        function showSection(targetId) {
            sections.forEach(section => {
                section.style.display = (section.id === targetId) ? 'block' : 'none';
            });

            navLinks.forEach(link => {
                link.classList.toggle('active', link.getAttribute('href') === `#${targetId}`);
            });

            // ✅ Only call dashboard load logic here
            if (targetId === 'dashboard') {
                loadUserDashboard();
            }
        }

        navLinks.forEach(link => {
            link.addEventListener('click', (event) => {
                const targetId = event.target.getAttribute('href')?.substring(1);
                if (targetId && document.getElementById(targetId)) {
                    event.preventDefault();
                    showSection(targetId);
                }
            });
        });



         // Show initial section (e.g., home or based on URL hash)
         const initialHash = window.location.hash.substring(1);
         if (initialHash && document.getElementById(initialHash)) {
             showSection(initialHash);
         } else {
             showSection('home'); // Default to home
         }

        // --- Placeholder Functions for Interactivity (To be implemented) ---

        // Function to fetch and display books based on search/filter
    function fetchBooks(query = '') {
        const bookList = document.getElementById('book-list');
        bookList.innerHTML = '<p class="text-center mt-3">Loading...</p>';

        fetch('fetch_books.php?title=' + encodeURIComponent(query))
            .then(res => res.json())
            .then(books => {
                bookList.innerHTML = '';

                if (books.length === 0) {
                    bookList.innerHTML = '<p class="text-center mt-3">No books found.</p>';
                    return;
                }

                books.forEach(book => {
                    const col = document.createElement('div');
                    col.className = 'col-md-4 mb-3';
                    col.innerHTML = `
                        <div class="card book-card">
                            <img src="${book.cover_url || 'https://placehold.co/600x400/EEE/31343C?text=No+Cover'}" class="card-img-top" alt="Book Cover">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">${book.title}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">${book.author}</h6>
                                <p class="card-text">Genre: ${book.genre || 'N/A'}</p>
                                <p class="card-text"><span class="badge ${book.status === 'available' ? 'bg-success' : 'bg-warning'}">${book.status}</span></p>
                                <a href="#book-detail" class="btn btn-secondary mt-auto view-details-btn" data-book-id="${book.book_id}">View Details</a>
                            </div>
                        </div>`;
                    bookList.appendChild(col);
                });

                addBookDetailEventListeners();
            })
            .catch(err => {
                console.error('Error loading books:', err);
                bookList.innerHTML = '<p class="text-danger text-center mt-3">Error fetching books.</p>';
            });
    }



        // Function to fetch and display details for a specific book
        async function fetchBookDetails(bookId) {
            try {
                const response = await fetch(`fetch_book_details.php?book_id=${bookId}`);
                const book = await response.json();

                if (book.error) {
                    alert(book.error);
                    return;
                }

                document.getElementById('detail-book-title').textContent = book.title;
                document.getElementById('detail-book-author').textContent = book.author;
                document.getElementById('detail-book-genre').textContent = book.genre || 'N/A';
                document.getElementById('detail-book-isbn').textContent = book.isbn || 'N/A';
                document.getElementById('detail-book-description').textContent = book.description || 'No description provided.';
                document.getElementById('detail-book-cover').src = book.cover_url || 'https://placehold.co/600x800/EEE/31343C?text=No+Image';

                const statusBadge = document.getElementById('detail-book-status');
                statusBadge.textContent = book.status;
                statusBadge.className = `badge ${book.status === 'available' ? 'bg-success' : 'bg-warning'}`;

                const borrowBtn = document.getElementById('borrow-return-btn');
                borrowBtn.dataset.bookId = book.book_id;
                borrowBtn.textContent = book.status === 'available' ? 'Borrow Book' : 'Return Book';
                borrowBtn.className = book.status === 'available' ? 'btn btn-primary' : 'btn btn-warning';

                showSection('book-detail');

            } catch (err) {
                console.error('Error fetching book details:', err);
                alert('Error loading book details.');
            }
        }


        // Function to handle book borrowing/returning
        function handleBorrowReturn(bookId, action) {
            const messageEl = document.getElementById('borrow-message');
            messageEl.style.display = 'none';

            fetch('borrow_return.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ book_id: bookId, action: action })
            })
            .then(response => response.text())
            .then(result => {
                if (result === 'borrowed' || result === 'returned') {
                    fetchBookDetails(bookId); // Refresh detail view
                } else {
                    messageEl.textContent = result;
                    messageEl.style.display = 'block';
                }
            })
            .catch(() => {
                messageEl.textContent = 'Network error. Try again.';
                messageEl.style.display = 'block';
            });
        }


        // --- Event Listeners ---
        // Search/Filter Form Submission
         document.getElementById('search-filter-form')?.addEventListener('submit', (event) => {
            event.preventDefault();
            const query = document.getElementById('searchInput').value.trim();
            fetchBooks(query); // Only pass the title
            showSection('browse');
        });



         // Reset Search Form
         document.getElementById('search-filter-form')?.addEventListener('reset', (event) => {
             fetchBooks(); // Fetch all books on reset
         });


        // Add listeners to dynamically added "View Details" buttons
        function addBookDetailEventListeners() {
            document.querySelectorAll('.view-details-btn').forEach(button => {
                // Remove existing listener to prevent duplicates
                const newButton = button.cloneNode(true);
                button.replaceWith(newButton);
            });

            document.querySelectorAll('.view-details-btn').forEach(button => {
                button.addEventListener('click', (event) => {
                    const bookId = event.currentTarget.dataset.bookId; // Use currentTarget
                    fetchBookDetails(bookId);
                });
            });
        }


        // Back to Browse Button
         document.getElementById('back-to-browse-btn')?.addEventListener('click', () => {
             showSection('browse');
             // Optional: Fetch books again if needed
             // fetchBooks();
         });

         // Borrow/Return Button in Detail View
         document.getElementById('borrow-return-btn')?.addEventListener('click', async (event) => {
            const bookId = event.target.dataset.bookId;
            const action = event.target.textContent.toLowerCase().includes('borrow') ? 'borrow' : 'return';

            try {
                const res = await fetch('borrow_return.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({ book_id: bookId, action })
                });

                const text = await res.text();

                if (res.ok) {
                    fetchBookDetails(bookId); // Refresh view
                } else {
                    document.getElementById('borrow-message').textContent = text;
                    document.getElementById('borrow-message').style.display = 'block';
                }
            } catch (err) {
                document.getElementById('borrow-message').textContent = 'Error processing request.';
                document.getElementById('borrow-message').style.display = 'block';
            }
        });


        // --- Form Validation (Example for Registration) ---
        const registerForm = document.getElementById('register-form');
        const registerPassword = document.getElementById('registerPassword');
        const confirmPassword = document.getElementById('registerConfirmPassword');
        const registerError = document.getElementById('register-error');

        registerForm?.addEventListener('submit', (event) => {
            registerError.style.display = 'none'; // Hide error initially
            if (registerPassword.value !== confirmPassword.value) {
                event.preventDefault(); // Stop form submission
                registerError.textContent = "Passwords do not match!";
                registerError.style.display = 'block';
                confirmPassword.focus();
            }
            // Add more validation (e.g., password strength, username availability check via AJAX)
            // If using AJAX instead of form action:
            // event.preventDefault();
            // Perform fetch() to register.php
            // Handle response (success message or error display)
        });

        // --- Admin Panel Logic (Placeholders) ---
         document.querySelectorAll('.edit-book-btn').forEach(btn => {
             btn.addEventListener('click', (e) => {
                 const bookId = e.target.dataset.bookId;
                 console.log(`Edit book ID: ${bookId}`);
                 // TODO: Populate the Add/Edit form with this book's data (fetch from server)
                 document.getElementById('edit-book-id').value = bookId; // Set hidden ID
                 document.getElementById('bookTitle').value = `Sample Book ${bookId}`; // Dummy data
                 // ... populate other fields ...
                 // Scroll to form or open modal
             });
         });
          document.querySelectorAll('.delete-book-btn').forEach(btn => {
             btn.addEventListener('click', (e) => {
                 const bookId = e.target.dataset.bookId;
                 if (confirm(`Are you sure you want to delete book ID: ${bookId}?`)) {
                     console.log(`Deleting book ID: ${bookId}`);
                     // TODO: Send delete request to PHP backend via fetch()
                     // On success, remove the row from the table
                 }
             });
         });
         // Add similar listeners for user/loan management buttons

        // --- Initial Setup ---
        addBookDetailEventListeners(); // Add listeners to initially loaded buttons (if any)

        document.getElementById('register-form')?.addEventListener('submit', async function (event) {
            event.preventDefault();

            const form = event.target;
            const formData = new FormData(form);
            const errorMsg = document.getElementById('register-error');
            const successMsg = document.getElementById('register-success');

            errorMsg.style.display = 'none';
            successMsg.style.display = 'none';

            try {
                const response = await fetch('register.php', {
                    method: 'POST',
                    body: formData
                });

                const text = await response.text();

                if (response.ok && text.includes("successful")) {
                    successMsg.textContent = text;
                    successMsg.style.display = 'block';
                    form.reset();

                    // Hide modal after success
                    const modal = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
                    modal.hide();
                } else {
                    errorMsg.textContent = text || "Registration failed.";
                    errorMsg.style.display = 'block';
                }
            } catch (error) {
                errorMsg.textContent = "Network or server error.";
                errorMsg.style.display = 'block';
            }
        });

	document.getElementById('login-form')?.addEventListener('submit', async function (event) {
        event.preventDefault();

        const email = document.getElementById('loginEmail').value;
        const password = document.getElementById('loginPassword').value;
        const errorMsg = document.getElementById('login-error');

        errorMsg.style.display = 'none';

        try {
            const response = await fetch('login.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ email, password })
            });

            const text = await response.text();

            if (response.ok && text.trim() === 'success') {
                window.location.reload(); // or redirect somewhere specific
            } else {
                errorMsg.textContent = text || 'Login failed.';
                errorMsg.style.display = 'block';
            }
        } catch (err) {
            errorMsg.textContent = 'Network error. Please try again.';
            errorMsg.style.display = 'block';
        }
});

    document.getElementById('add-edit-book-form')?.addEventListener('submit', async function (event) {
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);
        const messageEl = document.getElementById('admin-book-message');
        messageEl.style.display = 'none';

        try {
            const response = await fetch('add_book.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.text();
            if (response.ok && result.toLowerCase().includes("book added")) {
                messageEl.textContent = "Book successfully added!";
                messageEl.style.display = 'block';
                form.reset();
            } else {
                messageEl.textContent = result || "Failed to add book.";
                messageEl.style.display = 'block';
            }
        } catch (error) {
            messageEl.textContent = "Server error. Try again.";
            messageEl.style.display = 'block';
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        fetchBooks(); // Load books initially
    });

    function loadUserDashboard() {
        loadCurrentLoans();     // Loads currently borrowed books
        loadLoanHistory();      // Loads user's full borrowing history
    }

    async function loadLoanHistory() {
        const tbody = document.querySelector('#borrowing-history tbody');
        tbody.innerHTML = '<tr><td colspan="4" class="text-center">Loading...</td></tr>';

        try {
            const res = await fetch('fetch_loans_history.php');
            const history = await res.json();

            if (!Array.isArray(history) || history.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4" class="text-center">No borrowing history found.</td></tr>';
                return;
            }

            tbody.innerHTML = '';
            history.forEach(loan => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${loan.title}</td>
                    <td>${loan.author}</td>
                    <td>${loan.borrowed_on.split(' ')[0]}</td>
                    <td>${loan.returned_on ? loan.returned_on : '-'}</td>
                `;
                tbody.appendChild(tr);
            });
        } catch (err) {
            console.error('Failed to load loan history:', err);
            tbody.innerHTML = '<tr><td colspan="4" class="text-danger text-center">Error loading data</td></tr>';
        }
    }

    function loadCurrentLoans() {
        const borrowedList = document.getElementById('borrowed-books-list');
        borrowedList.innerHTML = ''; // ✅ Clear previous content

        fetch('fetch_loans.php')
            .then(res => res.json())
            .then(loans => {
                if (loans.length === 0) {
                    borrowedList.innerHTML = '<p class="mt-3">You have no books currently borrowed.</p>';
                    return;
                }

                const listGroup = document.createElement('div');
                listGroup.className = 'list-group';

                loans.forEach(loan => {
                    const item = document.createElement('div');
                    item.className = 'list-group-item list-group-item-action';
                    item.innerHTML = `
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">${loan.title}</h5>
                            <small>Due: ${loan.due_date}</small>
                        </div>
                        <p class="mb-1">${loan.author}</p>
                        <button class="btn btn-sm btn-warning return-btn" data-loan-id="${loan.loan_id}">Return Book</button>
                    `;
                    listGroup.appendChild(item);
                });

                borrowedList.appendChild(listGroup);
            })
            .catch(err => {
                console.error('Error loading current loans:', err);
                borrowedList.innerHTML = '<p class="text-danger mt-3">Error fetching current loans.</p>';
            });
    }


    </script>

</body>
</html>
