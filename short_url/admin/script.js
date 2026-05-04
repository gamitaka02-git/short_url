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

    // ======= 5.1. クリック数リセット機能 =======
    const resetBtns = document.querySelectorAll('.reset-btn');
    resetBtns.forEach(btn => {
        btn.addEventListener('click', async () => {
            const id = btn.getAttribute('data-id');
            const keyword = btn.getAttribute('data-keyword');

            if (!confirm(`本当にこの短縮URLのクリック数とログをリセットしますか？\n(スラッグ: ${keyword})\n※この操作は取り消せません。`)) {
                return;
            }

            const formData = new FormData();
            formData.append('action', 'reset_clicks');
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
                    alert(data.message || 'リセットに失敗しました。');
                }
            } catch (err) {
                console.error(err);
                alert('通信エラーが発生しました。');
            }
        });
    });

    // ======= 5.5. クリック解析モーダル =======
    const clickLogModal = document.getElementById('clickLogModal');
    const closeClickLogModal = document.getElementById('closeClickLogModal');
    const clickLogKeyword = document.getElementById('clickLogKeyword');
    const clickLogTotalCount = document.getElementById('clickLogTotalCount');
    const clickLogLoading = document.getElementById('clickLogLoading');
    const clickLogTableContainer = document.getElementById('clickLogTableContainer');
    const clickLogTableBody = document.getElementById('clickLogTableBody');
    const clickLogEmpty = document.getElementById('clickLogEmpty');
    const csvDownloadBtn = document.getElementById('csvDownloadBtn');

    // CSV出力用: 現在表示中のログデータを保持
    let currentClickLogs = [];
    let currentClickKeyword = '';

    // クリックバッジのイベントリスナー
    const clickLogBtns = document.querySelectorAll('.click-log-btn');
    clickLogBtns.forEach(btn => {
        btn.addEventListener('click', async () => {
            const urlId = btn.getAttribute('data-id');
            const keyword = btn.getAttribute('data-keyword');

            // モーダルを開く
            clickLogModal.classList.remove('hidden');
            clickLogModal.classList.add('flex');
            clickLogKeyword.textContent = `/ ${keyword}`;

            // UIリセット
            clickLogLoading.classList.remove('hidden');
            clickLogTableContainer.classList.add('hidden');
            clickLogEmpty.classList.add('hidden');
            clickLogTableBody.innerHTML = '';

            try {
                const formData = new FormData();
                formData.append('action', 'click_logs');
                formData.append('url_id', urlId);

                const res = await fetch('index.php', { method: 'POST', body: formData });
                const data = await res.json();

                clickLogLoading.classList.add('hidden');

                if (data.success) {
                    clickLogTotalCount.textContent = data.click_count;

                    // CSV出力用にデータを保持
                    currentClickLogs = data.logs || [];
                    currentClickKeyword = data.keyword || keyword;

                    if (data.logs && data.logs.length > 0) {
                        data.logs.forEach((log, index) => {
                            const tr = document.createElement('tr');
                            tr.className = index % 2 === 0 ? 'bg-white' : 'bg-gray-50';

                            const refererDisplay = log.referer
                                ? `<a href="${escapeHtml(log.referer)}" target="_blank" class="text-blue-600 hover:underline break-all">${escapeHtml(log.referer)}</a>`
                                : '<span class="text-gray-400 italic">（直接アクセス／不明）</span>';

                            tr.innerHTML = `
                                <td class="px-3 py-2 text-gray-500">${index + 1}</td>
                                <td class="px-3 py-2 whitespace-nowrap">${escapeHtml(log.clicked_at)}</td>
                                <td class="px-3 py-2 text-xs">${refererDisplay}</td>
                            `;
                            clickLogTableBody.appendChild(tr);
                        });
                        clickLogTableContainer.classList.remove('hidden');
                    } else {
                        clickLogEmpty.classList.remove('hidden');
                    }
                } else {
                    clickLogEmpty.classList.remove('hidden');
                }
            } catch (err) {
                console.error(err);
                clickLogLoading.classList.add('hidden');
                clickLogEmpty.classList.remove('hidden');
            }
        });
    });

    // HTMLエスケープ関数
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // モーダルを閉じる
    if (closeClickLogModal) {
        closeClickLogModal.addEventListener('click', () => {
            clickLogModal.classList.add('hidden');
            clickLogModal.classList.remove('flex');
        });
    }

    // ======= 5.6. CSVダウンロード機能 =======
    if (csvDownloadBtn) {
        csvDownloadBtn.addEventListener('click', () => {
            if (currentClickLogs.length === 0) {
                alert('ダウンロードするクリックログがありません。');
                return;
            }

            // BOM付きUTF-8 CSVを生成
            const bom = '\uFEFF';
            const header = 'No.,クリック日時,リファラ';
            const rows = currentClickLogs.map((log, index) => {
                const referer = log.referer || '（直接アクセス／不明）';
                // CSVエスケープ: ダブルクォートを含む場合はエスケープ
                const escapeCsv = (val) => {
                    if (val.includes('"') || val.includes(',') || val.includes('\n')) {
                        return '"' + val.replace(/"/g, '""') + '"';
                    }
                    return val;
                };
                return `${index + 1},${escapeCsv(log.clicked_at)},${escapeCsv(referer)}`;
            });

            const csvContent = bom + header + '\n' + rows.join('\n');
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);

            const a = document.createElement('a');
            a.href = url;
            a.download = `click_log_${currentClickKeyword}_${new Date().toISOString().slice(0,10)}.csv`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        });
    }

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

    // ======= 7. 設定モーダル制御 =======
    const settingsModal = document.getElementById('settingsModal');
    const openSettingsModalBtn = document.getElementById('openSettingsModalBtn');
    const closeSettingsModalBtn = document.getElementById('closeSettingsModal');

    if (openSettingsModalBtn && settingsModal) {
        openSettingsModalBtn.addEventListener('click', () => {
            if (passwordMessage) passwordMessage.classList.add('hidden');
            if (passwordForm) passwordForm.reset();
            settingsModal.classList.remove('hidden');
            settingsModal.classList.add('flex');
            
            // バッジが表示されていたら消す（確認したとみなす）
            const updateBadge = document.getElementById('updateBadge');
            if(updateBadge) updateBadge.classList.add('hidden');
        });
    }

    if (closeSettingsModalBtn && settingsModal) {
        closeSettingsModalBtn.addEventListener('click', () => {
            settingsModal.classList.add('hidden');
            settingsModal.classList.remove('flex');
            resetUpdateUI();
        });
    }

    // ======= 8. 更新チェック・自動アップデート =======
    const checkUpdateBtn = document.getElementById('checkUpdateBtn');
    const executeUpdateBtn = document.getElementById('executeUpdateBtn');
    const updateResultArea = document.getElementById('updateResultArea');
    const updateMessage = document.getElementById('updateMessage');
    const updateDetails = document.getElementById('updateDetails');
    const updateActionArea = document.getElementById('updateActionArea');
    const updateBadge = document.getElementById('updateBadge');

    function resetUpdateUI() {
        if(updateResultArea) updateResultArea.classList.add('hidden');
        if(updateActionArea) updateActionArea.classList.add('hidden');
        if(updateDetails) {
            updateDetails.classList.add('hidden');
            updateDetails.textContent = '';
        }
        if(updateMessage) {
            updateMessage.textContent = '';
            updateMessage.className = 'mb-3 text-sm font-bold';
        }
    }

    // 手動更新チェック
    if(checkUpdateBtn) {
        checkUpdateBtn.addEventListener('click', async () => {
            const originalText = checkUpdateBtn.innerHTML;
            checkUpdateBtn.disabled = true;
            checkUpdateBtn.innerHTML = '<span class="animate-spin inline-block mr-2 text-white">⟳</span>チェック中...';
            resetUpdateUI();

            try {
                const formData = new FormData();
                formData.append('action', 'check');
                const res = await fetch('update.php', { method: 'POST', body: formData });
                const data = await res.json();

                updateResultArea.classList.remove('hidden');

                if(data.success) {
                    if(data.has_update) {
                        updateMessage.textContent = `最新バージョン v${data.latest_version} が利用可能です！`;
                        updateMessage.classList.add('text-green-600');
                        
                        // リリースノート等表示
                        if(data.release_notes) {
                            updateDetails.classList.remove('hidden');
                            updateDetails.textContent = data.release_notes;
                        }

                        updateActionArea.classList.remove('hidden');
                    } else {
                        updateMessage.textContent = 'お使いのシステムは最新版です。';
                        updateMessage.classList.add('text-blue-600');
                    }
                    
                    // チェックした日付を保存しておく
                    localStorage.setItem('last_shorturl_update_check', Date.now());
                } else {
                    updateMessage.textContent = data.message || 'チェックに失敗しました。';
                    updateMessage.classList.add('text-red-600');
                }
            } catch(e) {
                console.error(e);
                updateResultArea.classList.remove('hidden');
                updateMessage.textContent = '通信エラーが発生しました。';
                updateMessage.classList.add('text-red-600');
            } finally {
                checkUpdateBtn.disabled = false;
                checkUpdateBtn.innerHTML = originalText;
            }
        });
    }

    // アップデート実行
    if(executeUpdateBtn) {
        executeUpdateBtn.addEventListener('click', async () => {
            if(!confirm('自動アップデートを開始します。一部ファイルの書き換えが行われます。\n事前にデータのバックアップを取ることをお勧めします。よろしいですか？')) return;

            const originalText = executeUpdateBtn.innerHTML;
            executeUpdateBtn.disabled = true;
            executeUpdateBtn.innerHTML = '<span class="animate-spin inline-block mr-2 text-white">⟳</span>アップデート実行中 (数分かかる場合があります)...';
            executeUpdateBtn.classList.replace('bg-green-600', 'bg-gray-400');
            executeUpdateBtn.classList.replace('hover:bg-green-700', 'hover:bg-gray-400');

            try {
                const formData = new FormData();
                formData.append('action', 'execute');
                const res = await fetch('update.php', { method: 'POST', body: formData });
                const data = await res.json();

                if(data.success) {
                    alert(data.message + '\n\n設定を反映するため、ページを再読み込みします。');
                    location.reload();
                } else {
                    alert('アップデートエラー:\n' + (data.message || '不明なエラー'));
                }
            } catch(e) {
                console.error(e);
                alert('通信エラーが発生しました。アップデートが途中で失敗した可能性があります。');
            } finally {
                executeUpdateBtn.disabled = false;
                executeUpdateBtn.innerHTML = originalText;
                executeUpdateBtn.classList.replace('bg-gray-400', 'bg-green-600');
                executeUpdateBtn.classList.replace('hover:bg-gray-400', 'hover:bg-green-700');
            }
        });
    }

    // バックグラウンド自動チェック (7日に1回)
    async function autoCheckUpdate() {
        const lastCheck = localStorage.getItem('last_shorturl_update_check');
        const now = Date.now();
        // 7 days = 7 * 24 * 60 * 60 * 1000 = 604800000 ms
        if(!lastCheck || (now - parseInt(lastCheck)) > 604800000) {
            try {
                const formData = new FormData();
                formData.append('action', 'check');
                const res = await fetch('update.php', { method: 'POST', body: formData });
                const data = await res.json();
                
                if(data.success) {
                    localStorage.setItem('last_shorturl_update_check', Date.now());
                    
                    if(data.has_update && updateBadge) {
                        updateBadge.classList.remove('hidden');
                    }
                }
            } catch(e) {
                console.error("Auto update check failed:", e);
            }
        }
    }

    // 読み込み時にバックグラウンドでポロッとチェックを流す
    setTimeout(autoCheckUpdate, 2000);
});
