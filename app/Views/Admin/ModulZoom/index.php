<?php $this->extend('Admin/layout/template'); ?>

<?= $this->section('content') ?>
<!-- FullCalendar JS and CSS dependencies -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales/id.js"></script>
<!-- Font Awesome for icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4><?= $title ?></h4>
                </div>
                <div class="card-body">
                    <!-- Calendar Container -->
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Schedule Info Modal -->
    <div class="modal fade" id="scheduleInfoModal" tabindex="-1" role="dialog" aria-labelledby="scheduleInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scheduleInfoModalLabel">Detail Kegiatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="scheduleInfoContent">
                    <!-- Schedule details will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal">Tutup</button>
                    <a href="#" id="editScheduleBtn" class="btn btn-primary">Edit</a>
                    <a href="#" id="deleteScheduleBtn" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.team-color-legend {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin: 15px 0;
}
.team-color-legend > div {
    display: flex;
    align-items: center;
    margin-right: 15px;
    font-size: 0.9rem;
}
@media (max-width: 576px) {
    .team-color-legend {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Team color definitions
    const teamColors = {
        'IPDS': '#FF5733',
        'Produksi': '#33FF57',
        'Distribusi': '#3357FF',
        'Sosial': '#F033FF',
        'Neraca': '#FF9033',
        'PPSSDS': '#33FFF9'
    };
    const defaultColor = '#CCCCCC';
    
    // HTML escape function for security
    function escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
    
    // Initialize the calendar
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
        },
        locale: 'id',
        timeZone: 'local',
        selectable: true,
        selectMirror: true,
        editable: false,
        dayMaxEvents: true,
        
        // Fetch events from server
        events: function(info, successCallback, failureCallback) {
            fetch('<?= site_url('admin/zoom-monitoring/getMonthData') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new URLSearchParams({
                    start: info.startStr,
                    end: info.endStr
                })
            })
            .then(response => response.json())
            .then(data => {
                const events = data.schedules.map(schedule => {
                    const eventColor = teamColors[schedule.tim] || defaultColor;
                    return {
                        id: schedule.id,
                        title: schedule.nama_kegiatan,
                        start: schedule.start,
                        end: schedule.end,
                        allDay: schedule.allDay || false,
                        backgroundColor: eventColor,
                        borderColor: eventColor,
                        extendedProps: {
                            tim: schedule.tim,
                            durasi_jam: schedule.durasi_jam,
                            durasi_menit: schedule.durasi_menit
                        }
                    };
                });
                successCallback(events);
            })
            .catch(error => {
                console.error('Error fetching events:', error);
                failureCallback(error);
            });
        },
        
        // Handle event click - show modal with details
        eventClick: function(info) {
            const event = info.event;
            const startDate = new Date(event.start);
            const endDate = event.end ? new Date(event.end) : null;
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            };
            
            // Format time information
            let timeInfo;
            if (event.allDay) {
                timeInfo = startDate.toLocaleDateString('id-ID', { 
                    weekday: 'long', 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric'
                });
            } else {
                timeInfo = startDate.toLocaleDateString('id-ID', options);
                if (endDate) {
                    timeInfo += ' sampai ' + endDate.toLocaleDateString('id-ID', options);
                }
            }
            
            // Format time for header display
            const timeHeader = startDate.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            });
            
            // Format date for header display
            const dateHeader = startDate.toLocaleDateString('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long'
            });
            
            // Build modal content
            let modalContent = `
                <div class="event-details p-3">
                    <!-- Header Section with Tim badge and Date/Time -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="team-badge" style="background-color: ${event.backgroundColor}; padding: 6px 12px; 
                            color: white; border-radius: 4px; font-weight: 500; letter-spacing: 0.5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            <i class="fas fa-users me-1"></i> ${escapeHtml(event.extendedProps.tim)}
                        </div>
                        <div class="text-end">
                            <div class="event-date fw-bold">${dateHeader}</div>
                            <div class="event-time text-muted">
                                <i class="far fa-clock me-1"></i> ${timeHeader}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Event Title -->
                    <h4 class="event-title mb-3 pb-2" style="border-bottom: 1px solid #e9ecef; color: #333;">
                        ${escapeHtml(event.title)}
                    </h4>
                    
                    <!-- Event Details -->
                    <div class="event-info">
                        <div class="row mb-2">
                            <div class="col-4 fw-semibold text-muted">Jadwal Lengkap:</div>
                            <div class="col-8">${timeInfo}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 fw-semibold text-muted">Durasi:</div>
                            <div class="col-8">
                                <span class="badge bg-info text-bg-dark">
                                    <i class="far fa-hourglass me-1"></i>
                                    ${event.extendedProps.durasi_jam} jam ${event.extendedProps.durasi_menit} menit
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Update modal content and buttons
            document.getElementById('scheduleInfoContent').innerHTML = modalContent;
            document.getElementById('editScheduleBtn').href = '<?= site_url('admin/zoom-monitoring/edit/') ?>' + event.id;
            document.getElementById('deleteScheduleBtn').href = '<?= site_url('admin/zoom-monitoring/delete/') ?>' + event.id;
            
            // Show the modal using appropriate method
            showModal();
        },
        
        // Handle date click - redirect to create form
        dateClick: function(info) {
            window.location.href = '<?= site_url('admin/zoom-monitoring/create_zoom') ?>?date=' + info.dateStr;
        }
    });
    
    // Render the calendar
    calendar.render();
    
    // Create the color legend
    createTeamColorLegend();
    
    // Function to create team color legend
    function createTeamColorLegend() {
        const legendContainer = document.createElement('div');
        legendContainer.className = 'team-color-legend';
        
        for (const team in teamColors) {
            const legendItem = document.createElement('div');
            
            const colorBox = document.createElement('span');
            colorBox.style.display = 'inline-block';
            colorBox.style.width = '20px';
            colorBox.style.height = '20px';
            colorBox.style.backgroundColor = teamColors[team];
            colorBox.style.marginRight = '5px';
            colorBox.style.borderRadius = '3px';
            
            const teamName = document.createElement('span');
            teamName.textContent = team;
            
            legendItem.appendChild(colorBox);
            legendItem.appendChild(teamName);
            legendContainer.appendChild(legendItem);
        }
        
        calendarEl.parentNode.insertBefore(legendContainer, calendarEl.nextSibling);
    }

    // Modal functions - compatible with both Bootstrap 4 and 5
    function showModal() {
        // Bootstrap 5
        if (typeof bootstrap !== 'undefined') {
            const modalElement = document.getElementById('scheduleInfoModal');
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        } 
        // Bootstrap 4
        else if (typeof $ !== 'undefined') {
            $('#scheduleInfoModal').modal('show');
        }
    }

    function closeModal() {
        // Bootstrap 5
        if (typeof bootstrap !== 'undefined') {
            const modalElement = document.getElementById('scheduleInfoModal');
            const modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) {
                modal.hide();
            }
        } 
        // Bootstrap 4
        else if (typeof $ !== 'undefined') {
            $('#scheduleInfoModal').modal('hide');
        }
    }

    // Set up event handlers for closing the modal
    // For both Bootstrap 4 and 5 compatibility
    document.querySelectorAll('.close-modal, .modal-header .close').forEach(button => {
        button.addEventListener('click', function() {
            closeModal();
        });
    });
});
</script>
<?= $this->endSection() ?>