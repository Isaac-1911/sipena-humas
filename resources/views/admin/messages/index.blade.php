@extends('layouts.admin')

@section('content')

<div class="messages-container" data-aos="fade-up">

    {{-- HEADER --}}
    <div class="messages-header">
        <div>
            <h4 class="messages-title">
                <i class="bi bi-chat-dots me-2"></i>
                Pesan Masuk
            </h4>
            <p class="messages-subtitle">
                <i class="bi bi-envelope"></i> {{ $messages->total() }} pesan masuk
            </p>
        </div>
        <div class="header-stats">
            <div class="stat-badge unread">
                <i class="bi bi-envelope-exclamation"></i>
                <span id="unreadCount">{{ $messages->where('is_read', false)->count() }} Belum dibaca</span>
            </div>
        </div>
    </div>

    {{-- ALERTS --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 16px; background: linear-gradient(135deg, #D1FAE5 0%, #A7F3D0 100%); border: none; color: #065F46;">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill" style="font-size: 20px;"></i>
                <div class="flex-grow-1">{{ session('success') }}</div>
                <button type="button" class="btn-close" onclick="this.closest('.alert').remove()" style="filter: brightness(0) invert(0); opacity: 0.6;"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 16px; background: linear-gradient(135deg, #FEE2E2 0%, #FECACA 100%); border: none; color: #991B1B;">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-exclamation-triangle-fill" style="font-size: 20px;"></i>
                <div class="flex-grow-1">{{ session('error') }}</div>
                <button type="button" class="btn-close" onclick="this.closest('.alert').remove()" style="filter: brightness(0) invert(0); opacity: 0.6;"></button>
            </div>
        </div>
    @endif

    {{-- MESSAGES CONTENT --}}
    <div class="messages-wrapper">

        {{-- LEFT: MESSAGES LIST --}}
        <div class="messages-list-panel">
            <div class="messages-list-header">
                <div class="search-box-messages">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchMessage" placeholder="Cari pesan berdasarkan nama atau email...">
                </div>
                <div class="filter-buttons">
                    <button class="filter-btn active" data-filter="all">Semua</button>
                    <button class="filter-btn" data-filter="unread">Belum Dibaca</button>
                </div>
            </div>

            <div class="messages-list" id="messagesList">
                @forelse($messages as $msg)
                    <a href="javascript:void(0)"
                       onclick="selectMessage({{ $msg->id }})"
                       class="message-list-item {{ $selected && $selected->id == $msg->id ? 'active' : '' }} {{ !$msg->is_read ? 'unread' : '' }}"
                       data-id="{{ $msg->id }}"
                       data-name="{{ strtolower($msg->name) }}"
                       data-email="{{ strtolower($msg->email) }}"
                       data-read="{{ $msg->is_read ? 'read' : 'unread' }}">

                        <div class="message-avatar">
                            <div class="avatar-initials">
                                {{ strtoupper(substr($msg->name, 0, 2)) }}
                            </div>
                            @if(!$msg->is_read)
                                <span class="unread-dot"></span>
                            @endif
                        </div>

                        <div class="message-info">
                            <div class="message-sender">
                                <strong>{{ $msg->name }}</strong>
                                <span class="message-time">{{ $msg->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="message-subject">
                                {{ $msg->subject ?? 'Pesan Baru' }}
                            </div>
                            <div class="message-preview">
                                {{ \Illuminate\Support\Str::limit($msg->message, 60) }}
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="empty-messages">
                        <i class="bi bi-inbox"></i>
                        <p>Belum ada pesan masuk</p>
                    </div>
                @endforelse
            </div>

            @if($messages->hasPages())
                <div class="messages-pagination">
                    {{ $messages->links() }}
                </div>
            @endif
        </div>

        {{-- RIGHT: MESSAGE DETAIL --}}
        <div class="message-detail-panel" id="messageDetailPanel">
            @if($selected)
                <div class="message-detail-card">
                    <div class="message-detail-header">
                        <div class="message-detail-sender">
                            <div class="sender-avatar-large">
                                {{ strtoupper(substr($selected->name, 0, 2)) }}
                            </div>
                            <div class="sender-info">
                                <h5 id="detailName">{{ $selected->name }}</h5>
                                <span class="sender-email">
                                    <i class="bi bi-envelope"></i>
                                    <span id="detailEmail">{{ $selected->email }}</span>
                                </span>
                            </div>
                        </div>
                        <div class="message-date-large">
                            <i class="bi bi-calendar3"></i>
                            <span id="detailDate">{{ \Carbon\Carbon::parse($selected->created_at)->translatedFormat('l, d F Y H:i') }}</span>
                        </div>
                    </div>

                    <div class="message-detail-subject">
                        <h6 id="detailSubject">{{ $selected->subject ?? 'Pesan Masuk' }}</h6>
                    </div>

                    <div class="message-detail-body" id="detailMessage">
                        {!! nl2br(e($selected->message)) !!}
                    </div>

                    <div class="message-detail-actions">
                        <button onclick="openReplyModal('{{ $selected->id }}', '{{ $selected->email }}', '{{ $selected->subject ?? 'Balasan' }}')"
                                class="btn-reply">
                            <i class="bi bi-reply-fill me-2"></i>
                            Balas Pesan
                        </button>

                        @if(!$selected->is_read)
                            <button onclick="markAsRead({{ $selected->id }})" class="btn-mark-read">
                                <i class="bi bi-check2-circle me-2"></i>
                                Tandai Sudah Dibaca
                            </button>
                        @endif
                    </div>
                </div>
            @else
                <div class="no-message-selected">
                    <i class="bi bi-envelope-open"></i>
                    <h5>Tidak Ada Pesan Dipilih</h5>
                    <p>Pilih pesan dari daftar di sebelah kiri untuk melihat detailnya</p>
                </div>
            @endif
        </div>

    </div>

</div>

{{-- MODAL BALAS PESAN --}}
<div id="replyModal" class="modal-overlay" style="display: none;">
    <div class="modal-container">
        <div class="modal-header">
            <h5 class="modal-title">
                <i class="bi bi-reply-fill me-2"></i>
                Balas Pesan
            </h5>
            <button type="button" class="modal-close" id="closeReplyModalBtn">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.messages.reply') }}" id="replyForm">
            @csrf
            <input type="hidden" name="message_id" id="replyMessageId">
            <input type="hidden" name="original_message_id" id="originalMessageId">

            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-person me-1"></i>
                        Kepada
                    </label>
                    <input type="text" id="replyEmail" class="modern-input" readonly>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-tag me-1"></i>
                        Subjek
                    </label>
                    <input type="text" name="subject" id="replySubject" class="modern-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-chat-text me-1"></i>
                        Pesan Balasan
                    </label>
                    <textarea name="message" id="replyMessage" class="modern-textarea" rows="6" required placeholder="Tulis balasan Anda di sini..."></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" id="cancelReplyBtn">
                    <i class="bi bi-x-circle me-1"></i>
                    Batal
                </button>
                <button type="submit" class="btn btn-primary" style="background: var(--primary);">
                    <i class="bi bi-send me-1"></i>
                    Kirim Balasan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    let currentSelectedId = {{ $selected ? $selected->id : 'null' }};

    function selectMessage(messageId) {
        window.location.href = '{{ route("admin.messages.index") }}?id=' + messageId;
    }

 function markAsRead(messageId) {
    const url = '{{ route("admin.messages.mark-as-read", ":id") }}'.replace(':id', messageId);

    const markReadBtn = document.querySelector('.btn-mark-read');
    const originalText = markReadBtn ? markReadBtn.innerHTML : '';
    if (markReadBtn) {
        markReadBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> Memproses...';
        markReadBtn.disabled = true;
    }

    fetch(url, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update UI for the specific message in the list
            const messageItem = document.querySelector(`.message-list-item[data-id="${messageId}"]`);
            if (messageItem) {
                // Remove unread class
                messageItem.classList.remove('unread');
                // Remove unread dot
                const unreadDot = messageItem.querySelector('.unread-dot');
                if (unreadDot) unreadDot.remove();
                // Update dataset
                messageItem.dataset.read = 'read';

                // Update unread count
                updateUnreadCount();

                // Add visual feedback that it's been read
                messageItem.style.backgroundColor = '#F9FAFB';
                setTimeout(() => {
                    messageItem.style.backgroundColor = '';
                }, 500);
            }

            const actionContainer = document.querySelector('.message-detail-actions');
            if (actionContainer) {
                const markReadBtnElement = actionContainer.querySelector('.btn-mark-read');
                if (markReadBtnElement) {
                    markReadBtnElement.remove();
                }
            }

            showTemporaryMessage('Pesan telah ditandai sebagai sudah dibaca', 'success');

            // Optional: Reload the page to ensure consistency (uncomment if needed)
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showTemporaryMessage(data.message || 'Gagal menandai pesan', 'error');
            // Reset button if failed
            if (markReadBtn && originalText) {
                markReadBtn.innerHTML = originalText;
                markReadBtn.disabled = false;
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showTemporaryMessage('Terjadi kesalahan pada server', 'error');
        // Reset button if failed
        if (markReadBtn && originalText) {
            markReadBtn.innerHTML = originalText;
            markReadBtn.disabled = false;
        }
    });
}

    // Function to update unread count
    function updateUnreadCount() {
        const unreadItems = document.querySelectorAll('.message-list-item.unread');
        const unreadCount = unreadItems.length;
        const unreadCountSpan = document.getElementById('unreadCount');
        if (unreadCountSpan) {
            unreadCountSpan.textContent = unreadCount + ' Belum dibaca';
        }
    }

    // Function to show temporary message
    function showTemporaryMessage(message, type) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.style.borderRadius = '16px';
        alertDiv.style.position = 'fixed';
        alertDiv.style.top = '20px';
        alertDiv.style.right = '20px';
        alertDiv.style.zIndex = '9999';
        alertDiv.style.minWidth = '300px';
        alertDiv.innerHTML = `
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-${type === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill'}" style="font-size: 20px;"></i>
                <div class="flex-grow-1">${message}</div>
                <button type="button" class="btn-close" onclick="this.closest('.alert').remove()"></button>
            </div>
        `;

        if (type === 'success') {
            alertDiv.style.background = 'linear-gradient(135deg, #D1FAE5 0%, #A7F3D0 100%)';
            alertDiv.style.color = '#065F46';
        } else {
            alertDiv.style.background = 'linear-gradient(135deg, #FEE2E2 0%, #FECACA 100%)';
            alertDiv.style.color = '#991B1B';
        }

        document.body.appendChild(alertDiv);

        setTimeout(() => {
            alertDiv.remove();
        }, 3000);
    }

    // Search functionality
    const searchInput = document.getElementById('searchMessage');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            filterMessages();
        });
    }

    // Filter functionality
    const filterBtns = document.querySelectorAll('.filter-btn');
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            filterMessages();
        });
    });

    function filterMessages() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        const activeFilter = document.querySelector('.filter-btn.active').dataset.filter;
        const messageItems = document.querySelectorAll('.message-list-item');

        messageItems.forEach(item => {
            const name = item.dataset.name || '';
            const email = item.dataset.email || '';
            const isRead = item.dataset.read;

            let matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
            let matchesFilter = activeFilter === 'all' ||
                               (activeFilter === 'unread' && isRead === 'unread');

            if (matchesSearch && matchesFilter) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });

        // Update empty state
        const visibleItems = document.querySelectorAll('.message-list-item[style=""]');
        const messagesList = document.getElementById('messagesList');
        const emptyDiv = messagesList.querySelector('.empty-messages');

        if (visibleItems.length === 0 && !emptyDiv) {
            const emptyMsg = document.createElement('div');
            emptyMsg.className = 'empty-messages';
            emptyMsg.innerHTML = `
                <i class="bi bi-inbox"></i>
                <p>Tidak ada pesan yang ditemukan</p>
            `;
            messagesList.appendChild(emptyMsg);
        } else if (visibleItems.length > 0 && emptyDiv) {
            emptyDiv.remove();
        }
    }

    // Modal functions
    const replyModal = document.getElementById('replyModal');

    function openReplyModal(id, email, subject) {
        if (replyModal) {
            document.getElementById('replyMessageId').value = id;
            document.getElementById('originalMessageId').value = id;
            document.getElementById('replyEmail').value = email;
            document.getElementById('replySubject').value = 'Re: ' + subject;
            document.getElementById('replyMessage').value = '';
            replyModal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    }

    function closeReplyModal() {
        if (replyModal) {
            replyModal.style.display = 'none';
            document.body.style.overflow = '';
        }
    }

    // Modal close handlers
    document.getElementById('closeReplyModalBtn')?.addEventListener('click', closeReplyModal);
    document.getElementById('cancelReplyBtn')?.addEventListener('click', closeReplyModal);

    // Close modal when clicking outside
    if (replyModal) {
        replyModal.addEventListener('click', function(e) {
            if (e.target === replyModal) {
                closeReplyModal();
            }
        });
    }

    // Form validation
    const replyForm = document.getElementById('replyForm');
    if (replyForm) {
        replyForm.addEventListener('submit', function(e) {
            const subject = document.getElementById('replySubject');
            const message = document.getElementById('replyMessage');
            let hasError = false;

            // Remove existing error messages
            document.querySelectorAll('.error-feedback').forEach(el => el.remove());

            if (!subject.value.trim()) {
                showFormError(subject, 'Subjek wajib diisi');
                hasError = true;
            }

            if (!message.value.trim()) {
                showFormError(message, 'Pesan balasan wajib diisi');
                hasError = true;
            }

            if (hasError) {
                e.preventDefault();
                return false;
            }
        });
    }

    function showFormError(input, message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-feedback';
        errorDiv.innerHTML = '<i class="bi bi-exclamation-circle"></i> ' + message;
        input.parentNode.appendChild(errorDiv);
        input.style.borderColor = '#EF4444';

        input.addEventListener('focus', function() {
            errorDiv.remove();
            input.style.borderColor = '#E5E7EB';
        }, { once: true });
    }

    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                if (alert && alert.parentNode) {
                    alert.style.transition = 'opacity 0.3s ease';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        if (alert && alert.parentNode) {
                            alert.remove();
                        }
                    }, 300);
                }
            }, 5000);
        });
    }, 1000);

    document.addEventListener('DOMContentLoaded', function() {
        const activeMessage = document.querySelector('.message-list-item.active');
        if (activeMessage) {
            activeMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
</script>
@endsection
