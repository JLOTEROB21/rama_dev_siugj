FROM marioegc/siugj:0.0.42
WORKDIR /var/www
RUN rm -rf html
#RUN mkdir html
#COPY html/* /html
#RUN ln -s /mnt/e/E/'Proyectos consultoria'/'Rama Judicial'/LinkTic/Software/SIUGJ_Colombia/rama_dev_siugj/html html
ENV urlSite="http://127.0.0.1:80/"
ENV DB_Host="172.20.179.24:3306"
ENV DB_User="siugj_user"
ENV DB_Passwd="siugj123$"
ENV DB_DATABASE="siugj_work"
ENV microsoftGraphClientSecret_ENV_VAR=tI48Q~GrHiq~N6felzzKTheCp0QVVcIxeUsPCbkd
ENV microsoftGraphClientID_ENV_VAR=5286867b-e04d-4a5b-9d01-6f9e7ed21fa9
ENV googleClientSecret_ENV_VAR=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
ENV googleClientID_ENV_VAR=752918055015-iac0np6ak2f6siraepg24l5ce73ji1h2.apps.googleusercontent.com
ENV TimeSession="900"
EXPOSE 80
ENTRYPOINT ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]

