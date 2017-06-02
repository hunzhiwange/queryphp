/* -*- Mode: C; tab-width: 8; indent-tabs-mode: t; c-basic-offset: 8 -*- */
#ifndef __GLADE_BUILTINS_H__
#define __GLADE_BUILTINS_H__

#include <glib-object.h>
#include <gladeui/glade.h>

G_BEGIN_DECLS

typedef struct _GladeParamSpecObjects   GladeParamSpecObjects;
typedef struct _GladeParamSpecAccel     GladeParamSpecAccel;
typedef struct _GladeKey                GladeKey;


struct _GladeKey {
	guint  value;
	gchar *name;
};

extern const GladeKey GladeKeys[];

#define  GLADE_KEYS_LAST_ALPHANUM    "9"
#define  GLADE_KEYS_LAST_EXTRA       "questiondown"
#define  GLADE_KEYS_LAST_KP          "KP_9"
#define  GLADE_KEYS_LAST_FKEY        "F35"

#define GLADE_TYPE_STOCK               (glade_standard_stock_get_type())
#define GLADE_TYPE_STOCK_IMAGE         (glade_standard_stock_image_get_type())
#define	GLADE_TYPE_GLIST               (glade_glist_get_type())
#define	GLADE_TYPE_ACCEL_GLIST         (glade_accel_glist_get_type())
#define	GLADE_TYPE_PARAM_OBJECTS       (glade_param_objects_get_type())
#define	GLADE_TYPE_PARAM_ACCEL         (glade_param_accel_get_type())
#define GLADE_TYPE_ITEM_APPEARANCE     (glade_item_appearance_get_type())

#define GLADE_IS_STOCK(pspec) \
        (G_TYPE_CHECK_INSTANCE_TYPE ((pspec), GLADE_TYPE_STOCK))

#define GLADE_IS_STOCK_IMAGE(pspec) \
        (G_TYPE_CHECK_INSTANCE_TYPE ((pspec), GLADE_TYPE_STOCK_IMAGE))

#define GLADE_IS_PARAM_SPEC_OBJECTS(pspec)     \
        (G_TYPE_CHECK_INSTANCE_TYPE ((pspec),  \
         GLADE_TYPE_PARAM_OBJECTS))
#define GLADE_PARAM_SPEC_OBJECTS(pspec)        \
        (G_TYPE_CHECK_INSTANCE_CAST ((pspec),  \
         GLADE_TYPE_PARAM_OBJECTS, GladeParamSpecObjects))

#define GLADE_IS_PARAM_SPEC_ACCEL(pspec)       \
        (G_TYPE_CHECK_INSTANCE_TYPE ((pspec),  \
         GLADE_TYPE_PARAM_ACCEL))
#define GLADE_PARAM_SPEC_ACCEL(pspec)          \
        (G_TYPE_CHECK_INSTANCE_CAST ((pspec),  \
         GLADE_TYPE_PARAM_ACCEL, GladeParamSpecAccel))

GType        glade_standard_stock_get_type       (void) G_GNUC_CONST;
GType        glade_standard_stock_image_get_type (void) G_GNUC_CONST;
GType        glade_glist_get_type                (void) G_GNUC_CONST;
GType        glade_accel_glist_get_type          (void) G_GNUC_CONST;
GType        glade_param_objects_get_type        (void) G_GNUC_CONST;
GType        glade_param_accel_get_type          (void) G_GNUC_CONST;
GType        glade_item_appearance_get_type      (void) G_GNUC_CONST;

guint        glade_builtin_key_from_string (const gchar   *string);
const gchar *glade_builtin_string_from_key (guint          key);


GList       *glade_accel_list_copy         (GList         *accels);
void         glade_accel_list_free         (GList         *accels);



GParamSpec  *glade_param_spec_objects      (const gchar   *name,
					    const gchar   *nick,
					    const gchar   *blurb,
					    GType          accepted_type,
					    GParamFlags    flags);

GParamSpec  *glade_param_spec_accel        (const gchar   *name,
					    const gchar   *nick,
					    const gchar   *blurb,
					    GType          widget_type,
					    GParamFlags    flags);

void         glade_param_spec_objects_set_type (GladeParamSpecObjects *pspec,
						GType                  type);
GType        glade_param_spec_objects_get_type (GladeParamSpecObjects *pspec);

GParamSpec  *glade_standard_pixbuf_spec      (void);
GParamSpec  *glade_standard_gdkcolor_spec    (void);
GParamSpec  *glade_standard_objects_spec     (void);
GParamSpec  *glade_standard_stock_spec       (void);
GParamSpec  *glade_standard_stock_image_spec (void);
GParamSpec  *glade_standard_accel_spec       (void);
GParamSpec  *glade_standard_int_spec         (void);
GParamSpec  *glade_standard_uint_spec        (void);
GParamSpec  *glade_standard_string_spec      (void);
GParamSpec  *glade_standard_strv_spec        (void);
GParamSpec  *glade_standard_float_spec       (void);
GParamSpec  *glade_standard_boolean_spec     (void);

void         glade_standard_stock_append_prefix (const gchar *prefix);

gboolean     glade_keyval_valid              (guint val);

G_END_DECLS

#endif   /* __GLADE_BUILTINS_H__ */
