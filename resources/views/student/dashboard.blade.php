@extends('layouts.admin')

@section('title', 'Student Dashboard')

@section('content')

@php
    $user = auth()->user();
    $student = $user->student ?? null;

    $studentName = $student->name ?? $user->name ?? 'Student';
    $studentNo   = $student->student_no ?? $student->index_no ?? 'N/A';
@endphp

<style>
    /* Page entrance */
    .fade-in-up {
        animation: fadeInUp 0.7s ease both;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* Header card */
    .dash-header {
        background: linear-gradient(135deg, #6a1b9a, #8e24aa);
        border-radius: 16px;
        padding: 22px 22px;
        color: #fff;
        box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        position: relative;
        overflow: hidden;
    }
    .dash-header::before {
        content: "";
        position: absolute;
        right: -80px;
        top: -80px;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(255,255,255,0.15);
        animation: float 5s ease-in-out infinite;
    }
    .dash-header::after {
        content: "";
        position: absolute;
        left: -90px;
        bottom: -90px;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        background: rgba(255,255,255,0.10);
        animation: float 6s ease-in-out infinite;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(10px); }
    }

    .dash-title {
        font-size: 20px;
        font-weight: 700;
        margin: 0;
    }
    .dash-sub {
        margin-top: 6px;
        opacity: 0.95;
        font-size: 13px;
    }

    .pill {
        display: inline-flex;
        gap: 8px;
        align-items: center;
        background: rgba(255,255,255,0.16);
        border: 1px solid rgba(255,255,255,0.22);
        padding: 8px 12px;
        border-radius: 999px;
        margin-top: 12px;
        backdrop-filter: blur(6px);
        font-size: 13px;
    }
    .pill strong { font-weight: 700; }

    /* Subjects grid */
    .subjects-wrap {
        margin-top: 18px;
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        gap: 14px;
    }
    .subject-card {
        grid-column: span 6;
        background: #fff;
        border-radius: 16px;
        padding: 16px;
        border: 1px solid #eee;
        box-shadow: 0 8px 22px rgba(0,0,0,0.06);
        transition: transform .18s ease, box-shadow .18s ease;
        position: relative;
        overflow: hidden;
        animation: fadeInUp .65s ease both;
    }
    .subject-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 14px 30px rgba(0,0,0,0.10);
    }
    .subject-tag {
        display: inline-block;
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 999px;
        background: rgba(142,36,170,0.10);
        color: #6a1b9a;
        font-weight: 700;
    }
    .subject-name {
        margin-top: 10px;
        font-size: 15px;
        font-weight: 700;
        color: #222;
        line-height: 1.3;
    }
    .subject-actions {
        margin-top: 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .btn-modern {
        background: #f7d22eff;
        border: none;
        color: #000000ff;
        padding: 8px 12px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: transform .15s ease, opacity .15s ease;
        white-space: nowrap;
    }
    .btn-modern:hover {
        opacity: .92;
        transform: translateY(-1px);
        color: #fff;
        text-decoration: none;
    }

    .muted {
        color: #666;
        font-size: 12px;
    }

    /* Responsive */
    @media (max-width: 900px) {
        .subject-card { grid-column: span 12; }
    }

    /* Empty state */
    .empty {
        background: #fff;
        border-radius: 16px;
        padding: 18px;
        border: 1px dashed #ddd;
        color: #666;
        text-align: center;
        margin-top: 16px;
        animation: fadeInUp .6s ease both;
    }
</style>

<div class="fade-in-up">

    {{-- Header --}}
    <div class="dash-header">
        <h3 class="dash-title">Welcome, {{ $studentName }} 👋</h3>
        <div class="dash-sub">Here’s your dashboard. You can view attendance per subject.</div>

        <div class="pill">
            <span>🎓</span>
            <span>Index No:</span>
            <strong>{{ $student->student_number }}</strong>
        </div>
    </div>

    {{-- Subjects --}}
    @if(isset($subjects) && $subjects->count())
        <div class="subjects-wrap">
            @foreach($subjects as $i => $subject)
                <div class="subject-card" style="animation-delay: {{ ($i * 0.05) }}s;">
                    <span class="subject-tag">{{ $subject->code }}</span>

                    <div class="subject-name">
                        {{ $subject->name }}
                    </div>

                    <div class="subject-actions">
                        <div class="muted">Tap to see lecture-wise attendance</div>

                        <a href="{{ route('student.attendance.subject', $subject->id) }}"
                           class="btn-modern">
                            <span>📊</span> View Attendance
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty">
            <h4 style="margin:0 0 6px 0;">No subjects assigned</h4>
            <div>Please contact your lecturer/admin to assign subjects.</div>
        </div>
    @endif

</div>

@endsection
