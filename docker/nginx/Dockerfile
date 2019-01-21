FROM nginx

RUN apt-get update \
  && apt-get install -y \
	vim

COPY ./nginx.conf /etc/nginx/nginx.conf
COPY ./includes.d /etc/nginx/includes.d
COPY ./conf.d/* /etc/nginx/conf.d/

WORKDIR /src/www

CMD ["nginx", "-g", "daemon off;"]