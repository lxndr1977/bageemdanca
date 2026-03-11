<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inscrição Finalizada</title>
    @php
        $primaryColor = $systemConfig?->primary_color ?? '#b21653';
        $textColor = $systemConfig?->text_color ?? '#333333';
        $buttonColor = $systemConfig?->button_color ?? '#e91e63';
        $buttonTextColor = $systemConfig?->button_text_color ?? '#ffffff';
        $whatsapp = $systemConfig?->whatsapp ?? null;
        $whatsappLink = $whatsapp
            ? 'https://wa.me/' . preg_replace('/\D/', '', $whatsapp)
            : 'https://wa.me/';
    @endphp
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.6;
            color: {{ $textColor }};
            background-color: #f4f4f4;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .email-header {
            background-color: {{ $primaryColor }};
            padding: 30px 20px;
            text-align: center;
        }

        .email-header h1 {
            font-size: 26px;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 6px;
        }

        .email-header p {
            color: rgba(255,255,255,0.85);
            font-size: 14px;
        }

        .email-body { padding: 40px 30px; }

        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #555555;
        }

        .success-message {
            background-color: #fdf2f8;
            border-left: 4px solid {{ $primaryColor }};
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }

        .school-name {
            font-weight: bold;
            color: {{ $primaryColor }};
        }

        .section-title {
            font-size: 15px;
            font-weight: bold;
            color: #111827;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 2px solid #f3f4f6;
        }

        .section-block { margin-top: 20px; margin-bottom: 10px; }

        .section-block p {
            font-size: 14px;
            color: #374151;
            margin-bottom: 4px;
        }

        .choreo-item {
            background-color: #f9fafb;
            border-radius: 6px;
            padding: 12px 14px;
            margin-bottom: 8px;
        }

        .choreo-item p {
            font-size: 14px;
            color: #374151;
            margin-bottom: 2px;
        }

        .divider {
            border: none;
            border-top: 1px solid #e5e7eb;
            margin: 22px 0;
        }

        .payment-notice {
            background-color: #fffbeb;
            border: 1px solid #fcd34d;
            border-left: 4px solid #f59e0b;
            border-radius: 6px;
            padding: 20px;
            margin: 30px 0;
        }

        .payment-notice h4 {
            font-size: 15px;
            color: #92400e;
            margin-bottom: 8px;
        }

        .payment-notice p {
            font-size: 14px;
            color: #78350f;
            line-height: 1.7;
            margin-bottom: 14px;
        }

        .contact-notice {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-left: 4px solid #9ca3af;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
        }

        .contact-notice h4 {
            font-size: 15px;
            color: #374151;
            margin-bottom: 8px;
        }

        .contact-notice p {
            font-size: 14px;
            color: #6b7280;
            line-height: 1.7;
            margin-bottom: 14px;
        }

        .btn-primary {
            display: inline-block;
            background-color: {{ $buttonColor }};
            color: {{ $buttonTextColor }} !important;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: bold;
        }

        .btn-secondary {
            display: inline-block;
            background-color: transparent;
            color: {{ $primaryColor }} !important;
            text-decoration: none;
            padding: 11px 23px;
            border-radius: 6px;
            border: 1.5px solid {{ $primaryColor }};
            font-size: 14px;
            font-weight: bold;
        }

        .cta-container {
            text-align: center;
            margin: 36px 0 20px;
        }

        .cta-button {
            display: inline-block;
            background: {{ $buttonColor }};
            color: {{ $buttonTextColor }} !important;
            text-decoration: none;
            padding: 16px 32px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(178,22,83,0.3);
        }

        .email-footer {
            background-color: #f8fafc;
            padding: 28px 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            color: #64748b;
            font-size: 13px;
        }

        .app-name {
            font-weight: bold;
            color: {{ $primaryColor }};
            font-size: 15px;
            display: block;
            margin-bottom: 6px;
        }

        @media screen and (max-width: 600px) {
            .email-container { margin: 10px; border-radius: 4px; }
            .email-header { padding: 20px 15px; }
            .email-header h1 { font-size: 22px; }
            .email-body { padding: 24px 18px; }
            .cta-button { padding: 14px 24px; font-size: 15px; }
        }

        table { border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
    </style>
</head>
<body>
    <div class="email-container">

        <div class="email-header">
            <h1>Inscrição Finalizada com Sucesso!</h1>
            <p>{{ $systemConfig?->festival_name ?? 'Bagé em Dança' }}</p>
        </div>

        <div class="email-body">

            <div class="greeting">
                Olá, <strong>{{ $registration->school->user->name ?? 'usuário' }}</strong>!
            </div>

            <div class="success-message">
                A inscrição da escola <span class="school-name">{{ $registration->school->name }}</span> foi finalizada com sucesso!
                Confira abaixo o resumo completo da sua inscrição.
            </div>

            <div class="section-block">
                <div class="section-title">Dados da Escola</div>
                <p><strong>Nome:</strong> {{ $registration->school->name }}</p>
                <p><strong>Responsável:</strong> {{ $registration->school->responsible_name }}</p>
                <p><strong>E-mail do responsável:</strong> {{ $registration->school->responsible_email }}</p>
                <p><strong>WhatsApp:</strong> {{ $registration->school->responsible_phone }}</p>
                <p><strong>Endereço:</strong>
                    {{ $registration->school->street }}, {{ $registration->school->number }}
                    {{ $registration->school->complement ? ', ' . $registration->school->complement : '' }}
                    — {{ $registration->school->city }}/{{ $registration->school->state }}
                </p>
            </div>

            <hr class="divider">

            <div class="section-block">
                <div class="section-title">Equipe</div>
                @if(isset($registration->registration_data['members']) && count($registration->registration_data['members']))
                    @foreach($registration->registration_data['members'] as $member)
                        <p>
                            {{ $member['name'] }}
                            — {{ $member['member_type'] ?? 'Tipo' }}
                            — R$ {{ number_format($member['fee_amount'] ?? 0, 2, ',', '.') }}
                        </p>
                    @endforeach
                @else
                    <p style="color:#9ca3af;">Nenhum membro cadastrado.</p>
                @endif
            </div>

            <hr class="divider">

            <div class="section-block">
                <div class="section-title">Coreografias</div>
                @if(isset($registration->registration_data['choreographies']) && count($registration->registration_data['choreographies']))
                    @foreach($registration->registration_data['choreographies'] as $ch)
                        <div class="choreo-item">
                            <p><strong>{{ $ch['name'] }}</strong> — {{ $ch['type'] }}</p>
                            <p>Participantes: {{ count($ch['dancers'] ?? []) + count($ch['choreographers'] ?? []) }}</p>
                        </div>
                    @endforeach
                @else
                    <p style="color:#9ca3af;">Nenhuma coreografia cadastrada.</p>
                @endif
            </div>

            <hr class="divider">

            <div class="payment-notice">
                <h4>Atenção: Realize o Pagamento</h4>
                <p>
                    Para confirmar sua participação no evento, é necessário realizar o pagamento das taxas de inscrição.
                    <strong>Inscrições sem pagamento confirmado não serão validadas.</strong>
                </p>
                <a href="{{ $whatsappLink }}" class="btn-primary" target="_blank">
                    Falar sobre Pagamento
                </a>
            </div>

            <div class="contact-notice">
                <h4>Precisa fazer alguma alteração?</h4>
                <p>
                    Caso necessite alterar qualquer dado da sua inscrição, entre em contato diretamente com a gerência do evento.
                </p>
                <a href="{{ $whatsappLink }}" class="btn-secondary" target="_blank">
                    Fale Conosco
                </a>
            </div>

            <div class="cta-container">
                <a href="https://inscricoes.bageemdanca.com.br/home" class="cta-button">
                    Acessar Painel
                </a>
            </div>

        </div>

        <div class="email-footer">
            <span class="app-name">{{ $systemConfig?->festival_name ?? 'Bagé em Dança' }}</span>
            Este é um e-mail automático, por favor não responda diretamente a esta mensagem.
        </div>

    </div>
</body>
</html>