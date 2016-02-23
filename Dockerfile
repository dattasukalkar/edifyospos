FROM edifynowdocker/edifyospos


MAINTAINER "Datta" <datta.sukalkar@edifynow.com>

RUN apt-get -y update && apt-get install -y fortunes
