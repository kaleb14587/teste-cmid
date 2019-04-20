#### Adicionando Scheduled para processar a pasta /data/in

copie e cole o codigo abaixo no arquivo de agendador de tarefa do sistema que esta rodando, 
alterando a raiz do projeto `/path-to-your-project` 
``````php
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
``````

