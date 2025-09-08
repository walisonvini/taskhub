<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarefa Concluída</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #10b981;
        }
        .header h1 {
            color: #10b981;
            margin: 0;
            font-size: 24px;
        }
        .task-info {
            background-color: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #10b981;
        }
        .task-title {
            font-size: 20px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 10px;
        }
        .task-description {
            color: #6b7280;
            margin-bottom: 15px;
        }
        .task-details {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .detail-item {
            flex: 1;
            min-width: 150px;
        }
        .detail-label {
            font-weight: bold;
            color: #374151;
            font-size: 14px;
        }
        .detail-value {
            color: #6b7280;
            margin-top: 5px;
        }
        .status-badge {
            display: inline-block;
            background-color: #10b981;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .priority-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .priority-alta { background-color: #ef4444; color: white; }
        .priority-média, .priority-media { background-color: #f59e0b; color: white; }
        .priority-baixa { background-color: #10b981; color: white; }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
        .success-icon {
            font-size: 48px;
            color: #10b981;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="success-icon">✅</div>
            <h1>Parabéns! Tarefa Concluída</h1>
        </div>

        <p>Olá <strong>{{ $userName }}</strong>,</p>
        
        <p>Sua tarefa foi marcada como concluída com sucesso!</p>

        <div class="task-info">
            <div class="task-title">{{ $task->title }}</div>
            
            @if($task->description)
                <div class="task-description">{{ $task->description }}</div>
            @endif

            <div class="task-details">
                <div class="detail-item">
                    <div class="detail-label">Status</div>
                    <div class="detail-value">
                        <span class="status-badge">{{ ucfirst($task->status->value) }}</span>
                    </div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Prioridade</div>
                    <div class="detail-value">
                        <span class="priority-badge priority-{{ strtolower($task->priority->value) }}">
                            {{ ucfirst($task->priority->value) }}
                        </span>
                    </div>
                </div>
                
                @if($task->due_date)
                <div class="detail-item">
                    <div class="detail-label">Data Limite</div>
                    <div class="detail-value">{{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}</div>
                </div>
                @endif
                
                <div class="detail-item">
                    <div class="detail-label">Concluída em</div>
                    <div class="detail-value">{{ $completedAt }}</div>
                </div>
            </div>
        </div>

        <p>Continue assim! Você está fazendo um excelente trabalho.</p>

        <div class="footer">
            <p>Este é um email automático do sistema TaskHub.</p>
        </div>
    </div>
</body>
</html>
