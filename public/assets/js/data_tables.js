    document.addEventListener('DOMContentLoaded', function() {
            const tableIds = ['#kategoriTable', '#siswaTable', '#adminsTable', '#pengaduanTable'];
            const skipSearchBox = ['#pengaduanTable']; 

            tableIds.forEach(function(selector) {
                const tbl = document.querySelector(selector);
                if (!tbl) return;

                let config = {
                    paging: false,
                    info: false,
                    lengthChange: false,
                    searching: true,
                    dom: 't'
                };

                if (selector === '#pengaduanTable') {
                    config.columnDefs = [
                        { targets: 0, width: '5%' },
                        { targets: 1, width: '25%' },
                        { targets: 2, width: '15%' },
                        { targets: 3, width: '20%' },
                        { targets: 4, width: '20%' },
                        { targets: 5, width: '15%' }
                    ];
                }

                // If table has no real data rows (only an empty-state row with colspan), skip initializing DataTables
                const tbodyRows = tbl.querySelectorAll('tbody tr');
                let hasRealData = false;
                if (tbodyRows.length > 0) {
                    if (tbodyRows.length === 1) {
                        const tdCount = tbodyRows[0].querySelectorAll('td').length;
                        const firstTd = tbodyRows[0].querySelector('td');
                        const colspan = firstTd ? parseInt(firstTd.getAttribute('colspan') || '0', 10) : 0;
                        if (!(tdCount === 1 && colspan > 0)) {
                            hasRealData = true;
                        }
                    } else {
                        hasRealData = true;
                    }
                }

                if (!hasRealData) {
                    // do not initialize DataTables for empty tables to avoid column-count errors
                    return;
                }

                const $tbl = $(selector).DataTable(config);

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