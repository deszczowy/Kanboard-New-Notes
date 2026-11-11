PLUGIN_NAME?=Notes
VERSION?=v1.0.0
mkfile_path := $(abspath $(lastword $(MAKEFILE_LIST)))
mkfile_dir := $(dir $(mkfile_path))

all:
	@ echo "Build archive for plugin ${PLUGIN_NAME} version=${VERSION}"
	@ git archive HEAD --prefix=${PLUGIN_NAME}/ --format=zip -o ${mkfile_dir}/${PLUGIN_NAME}-${VERSION}.zip
