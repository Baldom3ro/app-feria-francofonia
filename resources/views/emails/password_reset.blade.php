<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Restablecer Contraseña - Feria de la Francofonía</title>
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #F3F4F6; margin: 0; padding: 0; color: #1F2937; }
        .container { max-width: 600px; margin: 40px auto; background-color: #FFFFFF; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); border: 1px solid #E5E7EB; }
        .header { background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%); color: #FFFFFF; text-align: center; padding: 40px 20px; }
        .header h1 { margin: 0; font-size: 26px; font-weight: 800; letter-spacing: -0.5px; }
        .content { padding: 40px 35px; text-align: center; line-height: 1.6; }
        .content h2 { margin-top: 0; color: #111827; font-size: 22px; font-weight: 700; }
        .content p { color: #4B5563; font-size: 16px; margin-bottom: 25px; }
        .btn-container { margin: 35px 0; }
        .btn { display: inline-block; background: linear-gradient(to right, #4F46E5, #7C3AED); color: #FFFFFF !important; text-decoration: none; padding: 14px 32px; border-radius: 12px; font-weight: 700; font-size: 16px; box-shadow: 0 4px 6px rgba(79, 70, 229, 0.3); transition: transform 0.2s; }
        .security-note { font-size: 13px; color: #6B7280; background-color: #F9FAFB; padding: 20px; border-radius: 12px; border-left: 4px solid #7C3AED; text-align: left; margin-top: 30px; }
        .footer { background-color: #F9FAFB; padding: 25px; text-align: center; font-size: 12px; color: #9CA3AF; border-top: 1px solid #F3F4F6; }
        .link-alt { word-break: break-all; color: #4F46E5; text-decoration: underline; font-size: 12px; margin-top: 20px; display: block; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Feria de Sabores de la Francofonía</h1>
        </div>
        
        <div class="content">
            <h2>¿Olvidaste tu contraseña?</h2>
            <p>Has recibido este correo electrónico porque recibimos una solicitud de restablecimiento de contraseña para tu cuenta en nuestra plataforma.</p>
            
            <div class="btn-container">
                <a href="{{ $url }}" class="btn">Restablecer Contraseña</a>
            </div>
            
            <div class="security-note">
                <strong>Información importante:</strong><br>
                • Este enlace de restablecimiento de contraseña expirará en <strong>60 minutos</strong>.<br>
                • Si no realizaste esta solicitud, no es necesario realizar ninguna otra acción.<br>
                • Por tu seguridad, nunca compartas este enlace con nadie.
            </div>

            <p style="margin-top: 30px; font-size: 14px; color: #9CA3AF;">
                Si tienes problemas para hacer clic en el botón, copia y pega la siguiente URL en tu navegador:
                <span class="link-alt">{{ $url }}</span>
            </p>
        </div>
        
        <div class="footer">
            &copy; 2026 Feria de la Francofonía. San Cristóbal de las Casas, Chiapas.<br>
            Este es un correo automático de seguridad, por favor no respondas.
        </div>
    </div>
</body>
</html>
