document.addEventListener('DOMContentLoaded', () => {

    // ======= 1. 生成フォームの送信処理 =======
    const createForm = document.getElementById('createForm');
    const createMessage = document.getElementById('createMessage');

    if (createForm) {
        createForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(createForm);
            formData.append('action', 'create');

            try {
                const res = await fetch('index.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await res.json();

                if (data.success) {
                    createMessage.textContent = '生成しました！再読み込みします...';
                    createMessage.className = 'text-green-600 text-sm mt-2 block font-bold';
                    setTimeout(() => location.reload(), 800);
                } else {
                    createMessage.textContent = data.message || 'エラーが発生しました。';
                    createMessage.className = 'text-red-600 text-sm mt-2 block font-bold';
                }
            } catch (err) {
                console.error(err);
                createMessage.textContent = '通信エラーが発生しました。';
                createMessage.className = 'text-red-600 text-sm mt-2 block font-bold';
            }
        });
    }

    // ======= 2. URLコピー機能 =======
    const copyBtns = document.querySelectorAll('.copy-btn');
    copyBtns.forEach(btn => {
        btn.addEventListener('click', async () => {
            const url = btn.getAttribute('data-url');
            try {
                await navigator.clipboard.writeText(url);
                const originalText = btn.textContent;
                btn.textContent = 'コピー完了';
                btn.classList.replace('bg-gray-300', 'bg-green-200');
                btn.classList.replace('text-gray-800', 'text-green-800');

                setTimeout(() => {
                    btn.textContent = originalText;
                    btn.classList.replace('bg-green-200', 'bg-gray-300');
                    btn.classList.replace('text-green-800', 'text-gray-800');
                }, 2000);
            } catch (err) {
                alert('コピーに失敗しました。');
            }
        });
    });

    // ======= 3. 編集モーダル制御 =======
    const editModal = document.getElementById('editModal');
    const closeModal = document.getElementById('closeModal');
    const editForm = document.getElementById('editForm');
    const editMessage = document.getElementById('editMessage');
    const editId = document.getElementById('editId');
    const editUrlInput = document.getElementById('editUrl');

    const editBtns = document.querySelectorAll('.edit-btn');
    editBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-id');
            const url = btn.getAttribute('data-url');

            editId.value = id;
            editUrlInput.value = url;
            editMessage.classList.add('hidden');

            editModal.classList.remove('hidden');
            editModal.classList.add('flex');
        });
    });

    if (closeModal) {
        closeModal.addEventListener('click', () => {
            editModal.classList.add('hidden');
            editModal.classList.remove('flex');
        });
    }

    // ======= 4. 編集フォームの送信処理 =======
    if (editForm) {
        editForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(editForm);
            formData.append('action', 'update');

            try {
                const res = await fetch('index.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await res.json();

                if (data.success) {
                    editMessage.textContent = '更新しました！再読み込みします...';
                    editMessage.className = 'text-green-600 text-sm mt-2 block font-bold';
                    setTimeout(() => location.reload(), 800);
                } else {
                    editMessage.textContent = data.message || 'エラーが発生しました。';
                    editMessage.className = 'text-red-600 text-sm mt-2 block font-bold';
                }
            } catch (err) {
                console.error(err);
                editMessage.textContent = '通信エラーが発生しました。';
                editMessage.className = 'text-red-600 text-sm mt-2 block font-bold';
            }
        });
    }

    // ======= 5. 削除機能 =======
    const deleteBtns = document.querySelectorAll('.delete-btn');
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', async () => {
            const id = btn.getAttribute('data-id');
            const keyword = btn.getAttribute('data-keyword');

            if (!confirm(`本当にこの短縮URLを削除しますか？\n(スラッグ: ${keyword})`)) {
                return;
            }

            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('id', id);

            try {
                const res = await fetch('index.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await res.json();

                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || '削除に失敗しました。');
                }
            } catch (err) {
                console.error(err);
                alert('通信エラーが発生しました。');
            }
        });
    });

    // ======= 6. パスワード変更機能 =======
    const passwordForm = document.getElementById('passwordForm');
    const passwordMessage = document.getElementById('passwordMessage');

    if (passwordForm) {
        passwordForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(passwordForm);
            formData.append('action', 'password');

            try {
                const res = await fetch('index.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await res.json();

                if (data.success) {
                    passwordMessage.textContent = 'パスワードを変更しました！再ログイン画面へ移動します...';
                    passwordMessage.className = 'text-green-600 text-sm mt-2 block font-bold';
                    passwordForm.reset();
                    setTimeout(() => location.href = 'index.php?action=logout', 1500);
                } else {
                    passwordMessage.textContent = data.message || 'エラーが発生しました。';
                    passwordMessage.className = 'text-red-600 text-sm mt-2 block font-bold';
                }
            } catch (err) {
                console.error(err);
                passwordMessage.textContent = '通信エラーが発生しました。';
                passwordMessage.className = 'text-red-600 text-sm mt-2 block font-bold';
            }
        });
    }

    // ======= 7. パスワード変更モーダル制御 =======
    const passwordModal = document.getElementById('passwordModal');
    const openPasswordModalBtn = document.getElementById('openPasswordModalBtn');
    const closePasswordModalBtn = document.getElementById('closePasswordModal');

    if (openPasswordModalBtn && passwordModal) {
        openPasswordModalBtn.addEventListener('click', () => {
            if (passwordMessage) passwordMessage.classList.add('hidden');
            if (passwordForm) passwordForm.reset();
            passwordModal.classList.remove('hidden');
            passwordModal.classList.add('flex');
        });
    }

    if (closePasswordModalBtn && passwordModal) {
        closePasswordModalBtn.addEventListener('click', () => {
            passwordModal.classList.add('hidden');
            passwordModal.classList.remove('flex');
        });
    }
});
