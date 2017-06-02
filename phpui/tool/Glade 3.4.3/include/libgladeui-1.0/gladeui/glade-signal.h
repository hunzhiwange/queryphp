/* -*- Mode: C; tab-width: 8; indent-tabs-mode: t; c-basic-offset: 8 -*- */
#ifndef __GLADE_SIGNAL_H__
#define __GLADE_SIGNAL_H__

#include "glade-parser.h"

G_BEGIN_DECLS


#define GLADE_SIGNAL(s) ((GladeSignal *)s)
#define GLADE_IS_SIGNAL(s) (s != NULL)

typedef struct _GladeSignal  GladeSignal;

struct _GladeSignal
{
	gchar    *name;         /* Signal name eg "clicked"            */
	gchar    *handler;      /* Handler function eg "gtk_main_quit" */
	gchar    *userdata;     /* User data signal handler argument   */
	gboolean  lookup;       /* Whether user_data should be looked up
				 * with the GModule interface by libglade.
				 */
	gboolean  after;        /* Connect after TRUE or FALSE         */
};


GladeSignal *glade_signal_new   (const gchar *name,
				 const gchar *handler,
				 const gchar *userdata,
				 gboolean     lookup,
				 gboolean     after);
GladeSignal *glade_signal_clone (const GladeSignal *signal);
void         glade_signal_free  (GladeSignal *signal);

gboolean     glade_signal_equal (GladeSignal *sig1, GladeSignal *sig2);

gboolean     glade_signal_write (GladeSignalInfo *info, GladeSignal *signal,
				 GladeInterface *interface);

GladeSignal *glade_signal_new_from_signal_info (GladeSignalInfo *info);


G_END_DECLS

#endif /* __GLADE_SIGNAL_H__ */
