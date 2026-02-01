    document.addEventListener('DOMContentLoaded', function() {
            const tableIds = ['#kategoriTable', '#siswaTable', '#adminsTable', '#pengaduanTable'];
            const skipSearchBox = ['#pengaduanTable']; 

            tableIds.forEach(function(selector) {
                const tbl = document.querySelector(selector);
                if (!tbl) return;

                const $tbl = $(selector).DataTable({
                    paging: false,
                    info: false,
                    lengthChange: false,
                    searching: true,
                    dom: 't'
                });

                if (!skipSearchBox.includes(selector)) {
                    const card = tbl.closest('.card');
                    if (card) {
                        const header = card.querySelector('.card-header');
                        if (header) {
                            header.classList.add('d-flex', 'align-items-center', 'justify-content-between');
                            const searchWrapper = document.createElement('div');
                            searchWrapper.className = 'ms-auto d-flex align-items-center gap-2';

                            searchWrapper.innerHTML = `
                        <label class="mb-0 small fw-semibold text-dark" style="white-space: nowrap;">Cari:</label>
                        <input type="text" class="form-control form-control-sm" style="width: 200px;" placeholder="Ketik untuk mencari...">
                    `;

                            header.appendChild(searchWrapper);

                            const customInput = searchWrapper.querySelector('input');
                            customInput.addEventListener('keyup', function() {
                                $tbl.search(this.value).draw();
                            });
                        }
                    }
                }
            });
        });