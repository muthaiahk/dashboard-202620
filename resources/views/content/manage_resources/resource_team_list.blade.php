@extends('layouts.layoutMaster')

@section('title', 'Manage Team')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.scss', 'resources/assets/vendor/libs/flatpickr/flatpickr.scss', 'resources/assets/vendor/libs/dropzone/dropzone.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/jquery/jquery.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js', 'resources/assets/vendor/libs/nouislider/nouislider.js', 'resources/assets/vendor/libs/jquery-repeater/jquery-repeater.js', 'resources/assets/vendor/js/dropdown-hover.js'])
@endsection

@section('page-script')
    @vite(['resources/assets/js/forms_date_time_pickers.js'])
@endsection

@section('content')

    <style>
        .resource-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.25rem;
        }

        .resource-card {
            background: white;
            border-radius: 0.75rem;
            border: 1px solid #e5e7eb;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .team-avatar {
            width: 80px;
            height: 80px;
            background: #f3f4f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 1.5rem auto 1rem;
        }

        .team-name {
            font-size: 1.25rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 1rem;
        }

        .team-members-list {
            padding: 0 1.25rem 1.25rem;
            background: #f9fafb;
        }

        .member-item {
            background: white;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            margin-bottom: 0.75rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.95rem;
        }

        .role-badge {
            font-size: 0.8rem;
            padding: 0.35em 0.75em;
            border-radius: 1rem;
        }

        .card-footer {
            padding: 1rem;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
    </style>

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-3 pb-1">
            <div>
                <h4 class="card-title mb-1">Manage Teams</h4>
                <ul class="nav nav-tabs nav-tabs-border-bottom">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/manage_resources') }}">
                            <i class="mdi mdi-account-outline me-1"></i> Resources
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('/manage_team') }}">
                            <i class="mdi mdi-account-group-outline me-1"></i> Teams
                        </a>
                    </li>
                </ul>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div style="width: 320px; position: relative;">
                    <input type="text" id="teamSearchInput" class="form-control ps-5" placeholder="Search teams or members...">
                    <i class="mdi mdi-magnify position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                </div>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTeamModal">
                    <i class="mdi mdi-plus"></i> Add Team
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="resource-grid">

                @foreach($teams as $team)
                <div class="resource-card" id="team-card-{{ $team->id }}">
                    <div class="team-avatar">
                        <i class="mdi mdi-account-group text-primary" style="font-size: 2.5rem;"></i>
                    </div>
                    <h5 class="team-name">{{ $team->team_name }}</h5>

                    <div class="team-members-list">
                        <div class="member-item">
                            <span>{{ $team->supervisor->name ?? 'N/A' }}</span>
                            <span class="role-badge bg-warning-subtle text-warning">Supervisor</span>
                        </div>
                        <div class="member-item">
                            <span>{{ $team->technician->name ?? 'N/A' }}</span>
                            <span class="role-badge bg-primary-subtle text-primary">Technician</span>
                        </div>
                        <div class="member-item">
                            <span>{{ $team->driver->name ?? 'N/A' }}</span>
                            <span class="role-badge bg-info-subtle text-info">Driver</span>
                        </div>
                    </div>

                    <div class="card-footer d-flex gap-2 justify-content-center">
                        <button class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1 edit-team-btn"
                            data-id="{{ $team->id }}">
                            <i class="mdi mdi-pencil"></i> Manage Team
                        </button>
                        <button class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1 delete-team-btn"
                            data-id="{{ $team->id }}">
                            <i class="mdi mdi-delete"></i> 
                        </button>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>

    <!-- Add Team Modal -->
    <div class="modal fade" id="addTeamModal" tabindex="-1" aria-labelledby="addTeamModalLabel" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTeamModalLabel">Create New Team</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="addTeamForm">
                    @csrf

                    <div class="modal-body">
                        <div class="row g-3">

                            <div class="col-12">
                                <label class="form-label fw-bold">Team Name <span class="text-danger">*</span></label>
                                <input type="text" name="team_name" class="form-control" required>
                                <div class="invalid-feedback error-team_name"></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Supervisor <span class="text-danger">*</span></label>
                                <select name="supervisor_id" class="form-select select2-team" required>
                                    <option></option>
                                </select>
                                <div class="invalid-feedback error-supervisor_id"></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Driver <span class="text-danger">*</span></label>
                                <select name="driver_id" class="form-select select2-team" required>
                                    <option></option>
                                </select>
                                <div class="invalid-feedback error-driver_id"></div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Technicians <span class="text-danger">*</span></label>
                                <select name="technician_ids[]" class="form-select select2-team" multiple required>
                                    <option></option>
                                </select>
                                <div class="invalid-feedback error-technician_ids"></div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Other Staff (optional)</label>
                                <select name="other_staff_ids[]" class="form-select select2-team" multiple>
                                    <option></option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="saveTeamBtn">Create Team</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Team Modal -->
    <div class="modal fade" id="editTeamModal" tabindex="-1" aria-labelledby="editTeamModalLabel" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTeamModalLabel">Manage Team</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="editTeamForm">
                    @csrf
                    <input type="hidden" name="team_id" id="edit_team_id">

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-bold">Team Name <span class="text-danger">*</span></label>
                                <input type="text" name="team_name" id="edit_team_name" class="form-control" required>
                                <div class="invalid-feedback error-edit_team_name"></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Supervisor <span class="text-danger">*</span></label>
                                <select name="supervisor_id" id="edit_supervisor_id" class="form-select select2-team-edit" required>
                                    <option></option>
                                </select>
                                <div class="invalid-feedback error-edit_supervisor_id"></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Driver <span class="text-danger">*</span></label>
                                <select name="driver_id" id="edit_driver_id" class="form-select select2-team-edit" required>
                                    <option></option>
                                </select>
                                <div class="invalid-feedback error-edit_driver_id"></div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Technicians <span class="text-danger">*</span></label>
                                <select name="technician_ids[]" id="edit_technician_ids" class="form-select select2-team-edit" multiple required>
                                    <option></option>
                                </select>
                                <div class="invalid-feedback error-edit_technician_ids"></div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Other Staff (optional)</label>
                                <select name="other_staff_ids[]" id="edit_other_staff_ids" class="form-select select2-team-edit" multiple>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="updateTeamBtn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            // Select2 init helper
            function initSelect2(selector, modalElement) {
                $(selector).each(function() {
                    const currentElem = this;
                    if ($(currentElem).hasClass('select2-hidden-accessible')) {
                        $(currentElem).select2('destroy');
                    }
                    $(currentElem).select2({
                        dropdownParent: modalElement,
                        width: '100%',
                        placeholder: $(currentElem).prop('multiple') ? "Select multiple..." : "Select one...",
                        allowClear: true,
                        ajax: {
                            url: "{{ route('api.users') }}",
                            dataType: 'json',
                            delay: 250,
                            data: function(params) {
                                let selectedIds = [];
                                modalElement.find('.select2-team, .select2-team-edit').each(function() {
                                    if (this !== currentElem) {
                                        let val = $(this).val();
                                        if (val) {
                                            if (Array.isArray(val)) selectedIds.push(...val);
                                            else selectedIds.push(val);
                                        }
                                    }
                                });
                                
                                return { 
                                    search: params.term || '',
                                    exclude: selectedIds 
                                };
                            },
                            processResults: function(data) {
                                return { results: data };
                            }
                        }
                    });
                });
            }

            const modal = $('#addTeamModal');
            const editModal = $('#editTeamModal');

            modal.on('shown.bs.modal', function() {
                initSelect2('.select2-team', modal);
            });

            editModal.on('shown.bs.modal', function() {
                initSelect2('.select2-team-edit', editModal);
            });

            // Reset when modal hides
            modal.on('hidden.bs.modal', function() {
                $('#addTeamForm')[0].reset();
                $('.select2-team').val(null).trigger('change');
                $('.invalid-feedback').text('').removeClass('d-block');
            });

            editModal.on('hidden.bs.modal', function() {
                $('#editTeamForm')[0].reset();
                $('.select2-team-edit').val(null).trigger('change');
                $('.invalid-feedback').text('').removeClass('d-block');
            });

            // Card HTML generator function to append or update locally
            function renderTeamCard(team) {
                return `
                <div class="resource-card" id="team-card-${team.id}">
                    <div class="team-avatar">
                        <i class="mdi mdi-account-group text-primary" style="font-size: 2.5rem;"></i>
                    </div>
                    <h5 class="team-name">${team.team_name}</h5>

                    <div class="team-members-list">
                        <div class="member-item">
                            <span>${team.supervisor_name || 'N/A'}</span>
                            <span class="role-badge bg-warning-subtle text-warning">Supervisor</span>
                        </div>
                        <div class="member-item">
                            <span>${team.technician_name || 'N/A'}</span>
                            <span class="role-badge bg-primary-subtle text-primary">Technician</span>
                        </div>
                        <div class="member-item">
                            <span>${team.driver_name || 'N/A'}</span>
                            <span class="role-badge bg-info-subtle text-info">Driver</span>
                        </div>
                    </div>

                    <div class="card-footer d-flex gap-2 justify-content-center">
                        <button class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1 edit-team-btn"
                            data-id="${team.id}">
                            <i class="mdi mdi-pencil"></i> Manage Team
                        </button>
                        <button class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1 delete-team-btn"
                            data-id="${team.id}">
                            <i class="mdi mdi-delete"></i> 
                        </button>
                    </div>
                </div>
                `;
            }

            // Form submit via AJAX for Add
            $('#addTeamForm').off('submit').on('submit', function(e) {
                e.preventDefault();
                const btn = $('#saveTeamBtn');
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Creating...');

                $.ajax({
                    url: "{{ route('teams.store') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            modal.modal('hide');
                            $('.resource-grid').append(renderTeamCard(response.team));
                        }
                        btn.prop('disabled', false).text('Create Team');
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).text('Create Team');

                        if (xhr.status === 422) {
                            $('.invalid-feedback').text('').removeClass('d-block');
                            $.each(xhr.responseJSON.errors, function(field, messages) {
                                const key = field.replace('.', '_').replace('[]', '');
                                $(`.error-${key}`).text(messages[0]).addClass('d-block');
                            });
                        } else {
                            alert("Error: " + (xhr.responseJSON?.message || "Something went wrong"));
                        }
                    }
                });
            });

            // Open Edit Modal and Fetch Data
            $(document).on('click', '.edit-team-btn', function() {
                const id = $(this).data('id');
                const url = `{{ url('/teams/show') }}/${id}`;
                
                $.get(url, function(res) {
                    if (res.status) {
                        const team = res.data;
                        $('#edit_team_id').val(team.id);
                        $('#edit_team_name').val(team.team_name);
                        
                        // We must pre-load the name into the select2 option since it uses an ajax source
                        // We can just rely on the existing names locally passed or set the ID. 
                        // Wait, to show names in Select2 initialized via AJAX, we have to create an <option> and append it then select it
                        
                        // Helper to append option
                        function setSelect2Val(selector, id, text) {
                            if (id) {
                               var option = new Option(text || id, id, true, true);
                               $(selector).append(option).trigger('change');
                            }
                        }

                        // We fetch user names from all users if we need to show the exact name, or we can just send "Resource " + id
                        // Ideally the show api returns names. But team object has relationships or we can fetch. Let's send a simple text
                        setSelect2Val('#edit_supervisor_id', team.supervisor_id, team.supervisor?.name || 'Supervisor');
                        setSelect2Val('#edit_driver_id', team.driver_id, team.driver?.name || 'Driver');
                        
                        // Technicians might be array or single id. The controller handled it. But we stored it as single in technician_id
                        let techId = team.technician_id;
                        if (techId) {
                            setSelect2Val('#edit_technician_ids', techId, team.technician?.name || 'Technician');
                        }
                        
                        // Other staff
                        if(team.other_staff_ids) {
                            $('#edit_other_staff_ids').empty();
                            let staffs = JSON.parse(team.other_staff_ids) || team.other_staff_ids;
                            if (Array.isArray(staffs)) {
                                staffs.forEach(id => {
                                    setSelect2Val('#edit_other_staff_ids', id, 'Staff ' + id);
                                });
                            }
                        }

                        editModal.modal('show');
                    } else {
                        alert(res.message);
                    }
                });
            });

            // Form Submit via AJAX for Edit
            $('#editTeamForm').off('submit').on('submit', function(e) {
                e.preventDefault();
                const id = $('#edit_team_id').val();
                const btn = $('#updateTeamBtn');
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Updating...');

                $.ajax({
                    url: `{{ url('/teams/update') }}/${id}`,
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            editModal.modal('hide');
                            const team = response.data;
                            $(`#team-card-${team.id}`).replaceWith(renderTeamCard(team));
                        }
                        btn.prop('disabled', false).text('Save Changes');
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).text('Save Changes');

                        if (xhr.status === 422) {
                            $('.invalid-feedback').text('').removeClass('d-block');
                            $.each(xhr.responseJSON.errors, function(field, messages) {
                                const key = field.replace('.', '_').replace('[]', '');
                                $(`.error-edit_${key}`).text(messages[0]).addClass('d-block');
                            });
                        } else {
                            alert("Error: " + (xhr.responseJSON?.message || "Something went wrong"));
                        }
                    }
                });
            });

            // Delete Team via AJAX
            $(document).on('click', '.delete-team-btn', function() {
                if (!confirm("Are you sure you want to delete this team?")) return;
                
                const id = $(this).data('id');
                const btn = $(this);
                btn.prop('disabled', true);

                $.ajax({
                    url: `{{ url('/teams/delete') }}/${id}`,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status) {
                            $(`#team-card-${id}`).fadeOut(300, function() { $(this).remove(); });
                        } else {
                            alert(response.message);
                            btn.prop('disabled', false);
                        }
                    },
                    error: function() {
                        alert("An error occurred processing your request.");
                        btn.prop('disabled', false);
                    }
                });
            });

            // =========================
            // SEARCH FILTER
            // =========================
            $("#teamSearchInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                
                $(".resource-grid .resource-card").filter(function() {
                    let cardText = $(this).text().toLowerCase();
                    $(this).toggle(cardText.indexOf(value) > -1);
                });
            });
            
        });
    </script>

@endsection
