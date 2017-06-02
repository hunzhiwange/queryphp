/* -*- Mode: C; tab-width: 8; indent-tabs-mode: t; c-basic-offset: 8 -*- */
#ifndef __GLADE_EDITOR_PROPERTY_H__
#define __GLADE_EDITOR_PROPERTY_H__

G_BEGIN_DECLS

#define GLADE_TYPE_EDITOR_PROPERTY            (glade_editor_property_get_type())
#define GLADE_EDITOR_PROPERTY(obj)            (G_TYPE_CHECK_INSTANCE_CAST ((obj), GLADE_TYPE_EDITOR_PROPERTY, GladeEditorProperty))
#define GLADE_EDITOR_PROPERTY_CLASS(klass)    (G_TYPE_CHECK_CLASS_CAST ((klass), GLADE_TYPE_EDITOR_PROPERTY, GladeEditorPropertyClass))
#define GLADE_IS_EDITOR_PROPERTY(obj)         (G_TYPE_CHECK_INSTANCE_TYPE ((obj), GLADE_TYPE_EDITOR_PROPERTY))
#define GLADE_IS_EDITOR_PROPERTY_CLASS(klass) (G_TYPE_CHECK_CLASS_TYPE ((klass), GLADE_TYPE_EDITOR_PROPERTY))
#define GLADE_EDITOR_PROPERTY_GET_CLASS(o)    (G_TYPE_INSTANCE_GET_CLASS ((o), GLADE_EDITOR_PROPERTY, GladeEditorPropertyClass))


typedef struct _GladeEditorProperty        GladeEditorProperty;
typedef struct _GladeEditorPropertyClass   GladeEditorPropertyClass;

struct _GladeEditorProperty
{
	GtkHBox             parent_instance;

	GladePropertyClass *klass;          /* The property class this GladeEditorProperty was created for
					     */
	GladeProperty      *property;       /* The currently loaded property
					     */

	GtkWidget          *item_label;     /* Name of property (need a handle to set visual insensitive state)
					     */
	GtkWidget          *input;          /* Input part of property (need to set sensitivity seperately)
					     */

	GtkWidget          *check;          /* Check button for optional properties.
					     */

	GtkWidget          *info;           /* Informational button
					     */

	gulong              tooltip_id;     /* signal connection id for tooltip changes        */
	gulong              sensitive_id;   /* signal connection id for sensitivity changes    */
	gulong              changed_id;     /* signal connection id for value changes          */
	gulong              enabled_id;     /* signal connection id for enable/disable changes */
	
	gboolean            loading;        /* True during glade_editor_property_load calls, this
					     * is used to avoid feedback from input widgets.
					     */

	gboolean            use_command;    /* Whether we should use the glade command interface
					     * or skip directly to GladeProperty interface.
					     * (used for query dialogs).
					     */

	gboolean            show_info;      /* Whether we should show an informational button
					     * for this property
					     */
};

struct _GladeEditorPropertyClass {
	GtkHBoxClass  parent_class;

	void        (* load)          (GladeEditorProperty *, GladeProperty *);

	/* private */
	GtkWidget  *(* create_input)  (GladeEditorProperty *);

	void        (* gtk_doc_search)(GladeEditorProperty *, 
				       const gchar *,
				       const gchar *,
				       const gchar *);

};



GType                glade_editor_property_get_type       (void);

GladeEditorProperty *glade_editor_property_new            (GladePropertyClass  *klass,
							   gboolean             use_command);

GladeEditorProperty *glade_editor_property_new_from_widget (GladeWidget        *widget,
							    const gchar        *property,
							    gboolean            packing,
							    gboolean            use_command);

void                 glade_editor_property_load           (GladeEditorProperty *eprop,
							   GladeProperty       *property);

void                 glade_editor_property_load_by_widget (GladeEditorProperty *eprop,
							   GladeWidget         *widget);

gboolean             glade_editor_property_supported      (GParamSpec          *pspec);

void                 glade_editor_property_show_info      (GladeEditorProperty *eprop);

void                 glade_editor_property_hide_info      (GladeEditorProperty *eprop);


G_END_DECLS

#endif /* __GLADE_EDITOR_PROPERTY_H__ */
