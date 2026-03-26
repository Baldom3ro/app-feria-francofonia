<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tu Pase Oficial - Feria de la Francofonía</title>
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #F9FAFB; margin: 0; padding: 0; color: #1F2937; }
        .container { max-width: 600px; margin: 40px auto; background-color: #FFFFFF; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%); color: #FFFFFF; text-align: center; padding: 30px; }
        .header h1 { margin: 0; font-size: 24px; font-weight: bold; letter-spacing: 1px; }
        .content { padding: 40px 30px; text-align: center; }
        .content h2 { margin-top: 0; color: #111827; font-size: 20px; }
        .qr-box { background-color: #F3F4F6; padding: 20px; border-radius: 12px; display: inline-block; margin: 30px 0; border: 1px solid #E5E7EB; }
        .instructions { font-size: 15px; color: #4B5563; line-height: 1.6; background-color: #F8FAFC; padding: 20px; border-radius: 8px; border-left: 4px solid #4F46E5; text-align: left; }
        .footer { background-color: #F3F4F6; padding: 20px; text-align: center; font-size: 13px; color: #6B7280; }
        .btn { display: inline-block; background-color: #4F46E5; color: white; text-decoration: none; padding: 12px 24px; border-radius: 6px; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Feria de Sabores de la Francofonía</h1>
        </div>
        
        <div class="content">
            <h2>¡Hola, {{ $participant->name }}!</h2>
            <p>Tu registro oficial ha sido confirmado. Estamos muy emocionados de recibirte en este gran evento multicultural y gastronómico.</p>
            
            <div class="qr-box">
                <!-- Usamos una API externa confiable para generar el PNG en tiempo real porque Gmail/Outlook bloquean SVGs embebidos en Base64 -->
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data={{ urlencode($participant->id) }}&margin=1" alt="Tu código QR" width="220" height="220" style="display:block; margin:auto;">
            </div>
            
            <p style="font-size: 16px; font-weight: bold; color: #4F46E5;">Este es tu Pase Oficial</p>
            
            <div class="instructions">
                <strong>¿Cómo usar este código?</strong><br>
                1. Guarda este correo o toma una captura de pantalla del código QR.<br>
                2. Visita los stands en la Feria.<br>
                3. Presenta el QR al personal encargado de cada módulo para registrar tu visita e ingresar a la dinámica de encuestas.
            </div>
        </div>
        
        <div class="footer">
            &copy; 2026 Feria de la Francofonía. Todos los derechos reservados.<br>
            Este es un correo automático, por favor no respondas a esta dirección.
        </div>
    </div>
</body>
</html>
