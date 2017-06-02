/* -*- Mode: C; tab-width: 8; indent-tabs-mode: t; c-basic-offset: 8 -*- */
/*
 * glade.h
 *
 * Copyright (C) 2007 The GNOME Foundation.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 *
 */
#ifndef __GLADE_H__
#define __GLADE_H__

/* FIXME: forward declarations to get around circular header dependencies.
 */
typedef struct _GladeWidget    GladeWidget;
typedef struct _GladeProperty  GladeProperty;
typedef struct _GladeProject   GladeProject;

#include <gladeui/glade-widget-adaptor.h>
#include <gladeui/glade-widget.h>
#include <gladeui/glade-property-class.h>
#include <gladeui/glade-property.h>
#include <gladeui/glade-project.h>
#include <gladeui/glade-app.h>
#include <gladeui/glade-command.h>
#include <gladeui/glade-editor.h>
#include <gladeui/glade-editor-property.h>
#include <gladeui/glade-palette.h>
#include <gladeui/glade-clipboard.h>
#include <gladeui/glade-clipboard-view.h>
#include <gladeui/glade-inspector.h>
#include <gladeui/glade-placeholder.h>
#include <gladeui/glade-utils.h>
#include <gladeui/glade-builtins.h>
#include <gladeui/glade-fixed.h>

#endif /* __GLADE_H__ */
