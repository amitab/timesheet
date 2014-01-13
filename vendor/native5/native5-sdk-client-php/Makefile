export GIT_VERSION:=$(shell git describe --always)
export CURR_BUILD:=$(shell git rev-parse HEAD)
export PREV_BUILD:=$(shell awk -F"[,:]" '{for(i=1;i<=NF;i++){if($$i~/build\042/){print $$(i+1)} } }' VERSION)
version_list:= $(subst -, ,$(GIT_VERSION))
version_number:= $(word 1,$(version_list))
build_number:= $(word $(words $(version_list)),$(version_list))
builds:= $(words x $(wildcard dist/$(version_number)*))
vers = $(version_number)+build.$(builds).$(build_number)
stat=$(shell export SERVER_BUILD_VER=${vers})
#export NATIVE5_HOME:= $(CURDIR)/..

.PHONY: all 

all: dist docs
SOURCES:=$(shell find . -name *.php -type f | grep -v docs | grep -v setup | grep -v bin | grep -v tests)

clean: ${SOURCES}
	@echo "#############Clean up#############"
	@echo ${NATIVE5_HOME}
	rm -rf ${NATIVE5_HOME}/server/tmp
	rm -rf ${NATIVE5_HOME}/server/dist/*

init: clean version
	@echo "#############Copy necessary files#############"
	mkdir ${NATIVE5_HOME}/server/tmp
	mkdir -p ${NATIVE5_HOME}/server/dist
	cp -r ${NATIVE5_HOME}/server/core ${NATIVE5_HOME}/server/tmp/core;
	cp -r ${NATIVE5_HOME}/server/ext ${NATIVE5_HOME}/server/tmp/ext;
	cp ${NATIVE5_HOME}/server/index.php ${NATIVE5_HOME}/server/tmp/;
	
dist:init
	@echo "#############Creating distribution package#############"
	php ${NATIVE5_HOME}/tools/bin/package.php
	mkdir dist/${vers}
	mv dist/native5.phar dist/${vers}
	mv CHANGELOG dist/${vers}
	cp VERSION dist/${vers}

version: checkout
	@echo "######### Updating Version ##########";
	@echo "{">VERSION
	@echo '"version":"${vers}"', >>VERSION
	@echo '"build":"${CURR_BUILD}"'>>VERSION
	@echo "}">>VERSION

checkout: changes
	@echo "######### Updating codebase ##########";
	#@git pull

changes:
#ifneq ($(findstring $(CURR_BUILD),$(PREV_BUILD)),)
#   $(error No updates, exiting build script)
#endif
	@echo "######### Updating changelog ##########";
	@git log ${PREV_BUILD}..${CURR_BUILD} --pretty=format:"%h - %an, %ad : %s">CHANGELOG

docs: 
	@echo "#############Creating documentation#############"
	phpdoc
