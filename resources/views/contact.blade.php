@extends('layouts.landing')

@section('title', 'Contact Us - ' . ($logoSettings->site_name ?? ''))

@section('content')
    <div class="container" style="max-width:1100px;margin:36px auto;padding:20px;">
        <h2 style="color:var(--navy);margin:0 0 14px 0">Get In Touch With Us Now!</h2>

        @if (session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif
        <div class="panel">
            <div class="left">
                <div class="header">&nbsp;</div>
                <div class="info-grid">
                    <div class="info-card">
                        <div class="info-title">Phone Number</div>
                        <div class="info-sub">{{ $settings->contact_phone ?? '+880 01XXXXXXXXX' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-title">Email</div>
                        <div class="info-sub">{{ $settings->contact_email ?? 'support@loanlinker.net' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-title">Location</div>
                        <div class="info-sub">{{ $settings->contact_address ?? 'Mawna, Sreepur, Gazipur, Bangladesh' }}
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-title">Working Hours</div>
                        <div class="info-sub">{{ $settings->working_hours ?? 'Monday - Saturday<br>09:00 AM to 06:00 PM' }}
                        </div>
                    </div>
                </div>
            </div>


            <div class="right">
                <div class="header">Contact Us</div>
                <div class="form-wrap">
                    <div class="form-inner">
                        <form method="post" action="{{ route('contact.send') }}">
                            @csrf
                            <div class="form-row">
                                <div class="field">
                                    <label for="first">First Name *</label>
                                    <input id="first" name="first" type="text">
                                </div>
                                <div class="field">
                                    <label for="last">Last Name</label>
                                    <input id="last" name="last" type="text">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="field">
                                    <label for="mobile">Mobile No *</label>
                                    <input id="mobile" name="mobile" type="text">
                                </div>
                                <div class="field">
                                    <label for="email">Email ID *</label>
                                    <input id="email" name="email" type="email">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea id="message" name="message" rows="5" class="form-control @error('message') is-invalid @enderror"
                                    placeholder="Write your message here...">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div style="margin-bottom:12px">
                                <label>Please type the characters *</label>
                                <div class="captcha">
                                    <input name="captcha" type="text"
                                        style="flex:1;padding:10px;border-radius:6px;border:1px solid #d7d7db;background:#fff"
                                        value="{{ old('captcha') }}">
                                    <div class="box">
                                        @php
                                            $cap = session('contact_captcha') ?? '';
                                            $capSpaced = $cap ? implode(' ', str_split($cap)) : '';
                                        @endphp
                                        {{ $capSpaced }}
                                    </div>
                                </div>
                                @error('captcha')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="submit-wrap">
                                <button class="btn" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        :root {
            --navy: #112244;
            --muted: #f0f0f2;
            --accent: #0b2340;
            --box: #ffffff;
            --text: #222;
            --primary: #16325c
        }

        body {
            color: var(--text)
        }

        .panel {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            align-items: start
        }

        .left,
        .right {
            background: var(--box);
            border-radius: 6px;
            box-shadow: 0 6px 18px rgba(16, 24, 40, .06);
            overflow: hidden
        }

        .left .header,
        .right .header {
            background: var(--navy);
            color: #fff;
            padding: 14px 18px;
            font-weight: 700;
            text-align: center
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            padding: 28px
        }

        .info-card {
            padding: 18px;
            border-right: 1px solid #eee;
            border-bottom: 1px solid #f4f4f6;
            min-height: 110px;
            display: flex;
            flex-direction: column;
            justify-content: center
        }

        .info-card:last-child,
        .info-card:nth-child(2) {
            border-right: 0
        }

        .info-title {
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 8px
        }

        .info-sub {
            font-size: 13px;
            color: #444
        }

        .form-wrap {
            padding: 20px;
            background: #efefef
        }

        .form-inner {
            background: #e9e9ee;
            padding: 18px;
            border-radius: 4px
        }

        .form-row {
            display: flex;
            gap: 12px;
            margin-bottom: 12px
        }

        .form-row .field {
            flex: 1
        }

        .field label {
            display: block;
            font-size: 13px;
            margin-bottom: 6px
        }

        .field input[type=text],
        .field input[type=email],
        .field textarea {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #d7d7db;
            background: #fff
        }

        textarea {
            min-height: 110px;
            resize: vertical
        }

        .captcha {
            display: flex;
            gap: 12px;
            align-items: center
        }

        .captcha .box {
            background: #fff;
            padding: 10px 14px;
            border-radius: 4px;
            border: 1px solid #d3d3d7;
            font-weight: 700
        }

        .submit-wrap {
            text-align: right;
            margin-top: 12px
        }

        .btn {
            background: var(--navy);
            color: #fff;
            padding: 10px 18px;
            border-radius: 6px;
            border: 0;
            cursor: pointer
        }

        @media(max-width:900px) {
            .panel {
                grid-template-columns: 1fr
            }

            .info-grid {
                grid-template-columns: 1fr 1fr
            }

            .info-card {
                min-height: 90px
            }
        }

        @media(max-width:560px) {
            .info-grid {
                grid-template-columns: 1fr
            }

            .info-card {
                border-right: 0
            }
        }
    </style>
@endpush
