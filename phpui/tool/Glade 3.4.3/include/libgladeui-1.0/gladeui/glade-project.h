/* -*- Mode: C; tab-width: 8; indent-tabs-mode: t; c-basic-offset: 8 -*- */
#ifndef __GLADE_PROJECT_H__
#define __GLADE_PROJECT_H__

#include <gladeui/glade-widget.h>
#include <gladeui/glade-command.h>

G_BEGIN_DECLS

#define GLADE_TYPE_PROJECT            (glade_project_get_type ())
#define GLADE_PROJECT(obj)            (G_TYPE_CHECK_INSTANCE_CAST ((obj), GLADE_TYPE_PROJECT, GladeProject))
#define GLADE_PROJECT_CLASS(klass)    (G_TYPE_CHECK_CLASS_CAST ((klass), GLADE_TYPE_PROJECT, GladeProjectClass))
#define GLADE_IS_PROJECT(obj)         (G_TYPE_CHECK_INSTANCE_TYPE ((obj), GLADE_TYPE_PROJECT))
#define GLADE_IS_PROJECT_CLASS(klass) (G_TYPE_CHECK_CLASS_TYPE ((klass), GLADE_TYPE_PROJECT))
#define GLADE_PROJECT_GET_CLASS(obj)  (G_TYPE_INSTANCE_GET_CLASS ((obj), GLADE_TYPE_PROJECT, GladeProjectClass))

typedef struct _GladeProjectPrivate  GladeProjectPrivate;
typedef struct _GladeProjectClass    GladeProjectClass;

struct _GladeProject
{
	GObject parent_instance;

	GladeProjectPrivate *priv;
};

struct _GladeProjectClass
{
	GObjectClass parent_class;

	void          (*add_object)          (GladeProject *project,
					      GladeWidget  *widget);
	void          (*remove_object)       (GladeProject *project,
					      GladeWidget  *widget);
	
	void          (*undo)                (GladeProject *project);
	void          (*redo)                (GladeProject *project);
	GladeCommand *(*next_undo_item)      (GladeProject *project);
	GladeCommand *(*next_redo_item)      (GladeProject *project);
	void          (*push_undo)           (GladeProject *project,
					      GladeCommand *command);

	void          (*changed)             (GladeProject *project,
					      GladeCommand *command,
					      gboolean      forward);

	void          (*widget_name_changed) (GladeProject *project,
					      GladeWidget  *widget);
	void          (*selection_changed)   (GladeProject *project); 
	void          (*close)               (GladeProject *project);

	void          (*resource_added)      (GladeProject *project,
					      const gchar  *resource);
	void          (*resource_removed)    (GladeProject *project,
					      const gchar  *resource);
	void          (*parse_finished)      (GladeProject *project);
};


GType          glade_project_get_type            (void) G_GNUC_CONST;

GladeProject  *glade_project_new                 (void);

gboolean       glade_project_load_from_file      (GladeProject *project, const gchar *path);

GladeProject  *glade_project_load                (const gchar  *path);

gboolean       glade_project_save                (GladeProject *project, 
						  const gchar   *path, 
						  GError       **error);
						 
const gchar   *glade_project_get_path            (GladeProject *project);						 

gchar         *glade_project_get_name            (GladeProject *project);


void           glade_project_undo                (GladeProject *project);

void           glade_project_redo                (GladeProject *project);

GladeCommand  *glade_project_next_undo_item      (GladeProject *project);

GladeCommand  *glade_project_next_redo_item      (GladeProject *project);

void           glade_project_push_undo           (GladeProject *project, 
						  GladeCommand *cmd);

GtkWidget     *glade_project_undo_items          (GladeProject *project);

GtkWidget     *glade_project_redo_items          (GladeProject *project);

void           glade_project_reset_path          (GladeProject *project);

gboolean       glade_project_get_readonly        (GladeProject *project);

const GList   *glade_project_get_objects         (GladeProject *project);

void           glade_project_add_object          (GladeProject *project, 
						  GladeProject *old_project,
						  GObject      *object);

void           glade_project_remove_object       (GladeProject *project, GObject     *object);

gboolean       glade_project_has_object          (GladeProject *project, GObject     *object);

GladeWidget   *glade_project_get_widget_by_name  (GladeProject *project, const char  *name);

char          *glade_project_new_widget_name     (GladeProject *project, const char  *base_name);

void           glade_project_widget_name_changed (GladeProject *project, GladeWidget *widget,
						 const char   *old_name);

/* Selection */

gboolean       glade_project_is_selected         (GladeProject *project,
						 GObject      *object);

void           glade_project_selection_set       (GladeProject *project,
						 GObject      *object,
						 gboolean      emit_signal);

void           glade_project_selection_add       (GladeProject *project,
						 GObject      *object,
						 gboolean      emit_signal);

void           glade_project_selection_remove    (GladeProject *project,
						 GObject      *object,
						 gboolean      emit_signal);

void           glade_project_selection_clear     (GladeProject *project,
						 gboolean      emit_signal);

void           glade_project_selection_changed   (GladeProject *project);

GList         *glade_project_selection_get       (GladeProject *project);

gboolean       glade_project_get_has_selection   (GladeProject *project);

void           glade_project_set_accel_group     (GladeProject  *project, 
						  GtkAccelGroup *accel_group);

void           glade_project_set_resource         (GladeProject  *project, 
						   GladeProperty *property,
						   const gchar   *resource);

GList         *glade_project_list_resources       (GladeProject  *project);

gchar         *glade_project_resource_fullpath    (GladeProject  *project,
						   const gchar   *resource);
 
gboolean       glade_project_is_loading           (GladeProject *project);
 
time_t         glade_project_get_file_mtime       (GladeProject *project);
  
guint          glade_project_get_instance_count   (GladeProject *project);

void           glade_project_set_instance_count   (GladeProject *project, guint instance_count);

gboolean       glade_project_get_modified         (GladeProject *project);

G_END_DECLS

#endif /* __GLADE_PROJECT_H__ */
