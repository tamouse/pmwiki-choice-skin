#
# Makefile - build rules for mychoice pmwiki skin package
#
# \author Tamara Temple <tamara@tamaratemple.com>
# Time-stamp: <2012-03-20 14:34:28 tamara>
# \copyright (c) 2012 Tamara Temple
# \license GPLv3
# \package mychoice
#

P = $(shell basename `pwd`)

all:

release:
	(cd .. ;zip -r $(P).zip $(P) -x '$(P)/*~' -x '$(P)/.git*' -x '$(P)/*.zip';mv $(P).zip $(P))


