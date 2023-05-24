FROM marioegc/siugj:0.0.42
WORKDIR /var/www
RUN rm -rf html
RUN cp ./html html
ENV urlSite="https://albramaqa-971363870.us-east-1.elb.amazonaws.com:80/"
ENV DB_Host="10.210.85.17:3306"
ENV DB_User="userDb"
ENV DB_Passwd="Pwd123$"
ENV DB_DATABASE="SIUGJDB_QA"
ENV microsoftGraphClientSecret_ENV_VAR=tI48Q~GrHiq~N6felzzKTheCp0QVVcIxeUsPCbkd
ENV microsoftGraphClientID_ENV_VAR=5286867b-e04d-4a5b-9d01-6f9e7ed21fa9
ENV googleClientSecret_ENV_VAR=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
ENV googleClientID_ENV_VAR=752918055015-iac0np6ak2f6siraepg24l5ce73ji1h2.apps.googleusercontent.com
ENV TimeSession="900"
EXPOSE 80
ENTRYPOINT ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]

